/**
 * Course Management Panel JavaScript
 * 
 * Handles all frontend functionality for the course management panel
 * including authentication, course management, and live preview.
 * 
 * @package Mongruas
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    // Panel state
    let panelState = {
        isAuthenticated: false,
        currentCourse: null,
        courses: [],
        isLoading: false,
        autoSaveTimer: null,
        previewUpdateTimer: null,
        hasUnsavedChanges: false,
        pendingCourseSwitch: null
    };
    
    // DOM elements
    const elements = {
        trigger: null,
        modal: null,
        overlay: null,
        closeBtn: null,
        loginForm: null,
        mainPanel: null,
        loading: null,
        coursesList: null,
        courseEditor: null,
        coursePreview: null,
        courseForm: null
    };
    
    /**
     * Initialize the panel
     */
    function init() {
        // Cache DOM elements
        cacheElements();
        
        // Bind events
        bindEvents();
        
        // Check if user is already authenticated
        if (mongruasPanelAjax.is_admin) {
            checkAuthStatus();
        }
    }
    
    /**
     * Cache DOM elements
     */
    function cacheElements() {
        elements.trigger = $('#mongruas-panel-trigger');
        elements.modal = $('#mongruas-panel-modal');
        elements.overlay = $('.mongruas-panel-overlay');
        elements.closeBtn = $('#mongruas-panel-close');
        elements.loginForm = $('#mongruas-login-form');
        elements.mainPanel = $('#mongruas-main-panel');
        elements.loading = $('#panel-loading');
        elements.coursesList = $('#courses-list');
        elements.courseEditor = $('#course-editor');
        elements.coursePreview = $('#course-preview');
        elements.courseForm = $('#course-form');
    }
    
    /**
     * Bind event handlers
     */
    function bindEvents() {
        // Panel trigger
        elements.trigger.on('click', openPanel);
        
        // Close panel
        elements.closeBtn.on('click', closePanel);
        elements.overlay.on('click', closePanel);
        
        // ESC key to close
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && elements.modal.is(':visible')) {
                closePanel();
            }
        });
        
        // Login form
        $('#mongruas-auth-form').on('submit', handleLogin);
        
        // Course management
        $(document).on('click', '.course-item:not(.empty)', selectCourse);
        $(document).on('click', '#add-course-btn', addNewCourse);
        $(document).on('submit', '#course-form', saveCourse);
        $(document).on('input change', '#course-form input, #course-form textarea, #course-form select', function() {
            updatePreview();
            validateField($(this));
            scheduleAutoSave();
        });
        
        // Course reordering (drag and drop)
        initializeCourseReordering();
        
        // Enhanced warning about unsaved changes when leaving
        $(window).on('beforeunload', function(e) {
            if (panelState.hasUnsavedChanges && panelState.currentCourse) {
                const courseName = panelState.currentCourse.name || `Curso ${panelState.currentCourse.id}`;
                const changeCount = getChangeCount(getFormData());
                const message = `Tienes ${changeCount} cambio${changeCount !== 1 ? 's' : ''} sin guardar en "${courseName}". ¿Estás seguro de que quieres salir?`;
                e.returnValue = message;
                return message;
            }
        });
        
        // Enhanced warning when closing the panel with unsaved changes
        elements.closeBtn.add(elements.overlay).on('click', function(e) {
            if (panelState.hasUnsavedChanges && panelState.currentCourse) {
                e.preventDefault();
                e.stopPropagation();
                showUnsavedChangesDialog('close');
                return false;
            }
        });
        
        // Enhanced warning when switching courses with unsaved changes
        $(document).on('click', '.course-item:not(.empty)', function(e) {
            const targetCourseId = parseInt($(e.currentTarget).data('course-id'));
            
            if (panelState.hasUnsavedChanges && panelState.currentCourse && 
                panelState.currentCourse.id !== targetCourseId) {
                e.preventDefault();
                e.stopPropagation();
                
                // Store the target course for later use
                panelState.pendingCourseSwitch = targetCourseId;
                showUnsavedChangesDialog('switch');
                return false;
            }
        });
        
        // Image upload
        $(document).on('change', '#course-image-input', handleImageUpload);
        $(document).on('click', '.image-upload-area', function(e) {
            // Don't trigger file input if clicking on remove button
            if (!$(e.target).hasClass('btn-remove-image')) {
                $('#course-image-input').click();
            }
        });
        
        // Image removal
        $(document).on('click', '.btn-remove-image', function(e) {
            e.stopPropagation();
            removeImage();
        });
        
        // Drag and drop for images
        $(document).on('dragover dragenter', '.image-upload-area', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });
        
        $(document).on('dragleave', '.image-upload-area', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        });
        
        $(document).on('drop', '.image-upload-area', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
            
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                handleImageFile(files[0]);
            }
        });
    }
    
    /**
     * Open the panel
     */
    function openPanel() {
        elements.modal.fadeIn(300);
        
        if (panelState.isAuthenticated) {
            showMainPanel();
        } else {
            showLoginForm();
        }
    }
    
    /**
     * Close the panel
     */
    function closePanel() {
        elements.modal.fadeOut(300);
        clearLoginForm();
    }
    
    /**
     * Show login form
     */
    function showLoginForm() {
        elements.loginForm.show();
        elements.mainPanel.hide();
        elements.loading.hide();
        $('#panel-username').focus();
    }
    
    /**
     * Show main panel
     */
    function showMainPanel() {
        elements.loginForm.hide();
        elements.loading.hide();
        elements.mainPanel.show();
        
        if (panelState.courses.length === 0) {
            loadCourses();
        }
    }
    
    /**
     * Show loading state
     */
    function showLoading() {
        elements.loginForm.hide();
        elements.mainPanel.hide();
        elements.loading.show();
    }
    
    /**
     * Handle login form submission
     */
    function handleLogin(e) {
        e.preventDefault();
        
        const username = $('#panel-username').val().trim();
        const password = $('#panel-password').val();
        
        if (!username || !password) {
            showError('Por favor, completa todos los campos.');
            return;
        }
        
        showLoading();
        
        // Make login request
        $.ajax({
            url: mongruasPanelAjax.resturl + 'auth/login',
            method: 'POST',
            data: {
                username: username,
                password: password,
                nonce: mongruasPanelAjax.panel_nonce
            },
            success: function(response) {
                if (response.success) {
                    panelState.isAuthenticated = true;
                    // Update nonce
                    mongruasPanelAjax.nonce = response.nonce;
                    showMainPanel();
                    clearLoginForm();
                } else {
                    showError('Error de autenticación.');
                    showLoginForm();
                }
            },
            error: function(xhr) {
                let message = 'Error de conexión.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.status === 401) {
                    message = 'Credenciales incorrectas.';
                } else if (xhr.status === 403) {
                    message = 'Acceso denegado. Se requieren permisos de administrador.';
                } else if (xhr.status === 429) {
                    message = 'Demasiados intentos. Inténtalo más tarde.';
                }
                
                showError(message);
                showLoginForm();
            }
        });
    }
    
    /**
     * Check authentication status
     */
    function checkAuthStatus() {
        $.ajax({
            url: mongruasPanelAjax.resturl + 'auth/verify',
            method: 'POST',
            headers: {
                'X-WP-Nonce': mongruasPanelAjax.nonce
            },
            success: function(response) {
                if (response.success && response.is_admin) {
                    panelState.isAuthenticated = true;
                }
            },
            error: function() {
                panelState.isAuthenticated = false;
            }
        });
    }
    
    /**
     * Load courses from API
     */
    function loadCourses() {
        $.ajax({
            url: mongruasPanelAjax.resturl + 'courses',
            method: 'GET',
            headers: {
                'X-WP-Nonce': mongruasPanelAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    panelState.courses = response.data;
                    renderCoursesList();
                } else {
                    showError('Error al cargar los cursos.');
                }
            },
            error: function() {
                showError('Error de conexión al cargar los cursos.');
            }
        });
    }
    
    /**
     * Render courses list
     */
    function renderCoursesList() {
        let html = '';
        
        panelState.courses.forEach(function(course) {
            if (course.name) {
                html += `
                    <div class="course-item ${panelState.currentCourse && panelState.currentCourse.id === course.id ? 'active' : ''}" 
                         data-course-id="${course.id}" draggable="true">
                        <div class="course-item-drag-handle">⋮⋮</div>
                        <div class="course-item-content">
                            <div class="course-item-title">${escapeHtml(course.name)}</div>
                            <div class="course-item-meta">${escapeHtml(course.date || 'Sin fecha')}</div>
                            <div class="course-item-status ${course.isActive ? 'active' : 'inactive'}">
                                ${course.isActive ? 'Activo' : 'Inactivo'}
                            </div>
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="course-item empty" data-course-id="${course.id}">
                        <div>Curso ${course.id} - Vacío</div>
                        <div class="course-item-meta">Haz clic para añadir</div>
                    </div>
                `;
            }
        });
        
        elements.coursesList.html(html);
        
        // Re-initialize drag and drop after rendering
        initializeCourseReordering();
    }
    
    /**
     * Initialize course reordering functionality
     */
    function initializeCourseReordering() {
        let draggedElement = null;
        let draggedCourseId = null;
        
        // Drag start
        $(document).off('dragstart', '.course-item[draggable="true"]').on('dragstart', '.course-item[draggable="true"]', function(e) {
            draggedElement = this;
            draggedCourseId = $(this).data('course-id');
            $(this).addClass('dragging');
            
            // Set drag effect
            e.originalEvent.dataTransfer.effectAllowed = 'move';
            e.originalEvent.dataTransfer.setData('text/html', this.outerHTML);
        });
        
        // Drag end
        $(document).off('dragend', '.course-item[draggable="true"]').on('dragend', '.course-item[draggable="true"]', function(e) {
            $(this).removeClass('dragging');
            $('.course-item').removeClass('drag-over');
            draggedElement = null;
            draggedCourseId = null;
        });
        
        // Drag over
        $(document).off('dragover', '.course-item').on('dragover', '.course-item', function(e) {
            e.preventDefault();
            e.originalEvent.dataTransfer.dropEffect = 'move';
            
            if (this !== draggedElement) {
                $(this).addClass('drag-over');
            }
        });
        
        // Drag leave
        $(document).off('dragleave', '.course-item').on('dragleave', '.course-item', function(e) {
            $(this).removeClass('drag-over');
        });
        
        // Drop
        $(document).off('drop', '.course-item').on('drop', '.course-item', function(e) {
            e.preventDefault();
            $(this).removeClass('drag-over');
            
            if (this !== draggedElement && draggedCourseId) {
                const targetCourseId = $(this).data('course-id');
                
                if (targetCourseId && targetCourseId !== draggedCourseId) {
                    reorderCourses(draggedCourseId, targetCourseId);
                }
            }
        });
    }
    
    /**
     * Reorder courses by swapping positions
     */
    function reorderCourses(fromId, toId) {
        // Find the courses to swap
        const fromIndex = panelState.courses.findIndex(c => c.id === fromId);
        const toIndex = panelState.courses.findIndex(c => c.id === toId);
        
        if (fromIndex === -1 || toIndex === -1) {
            showError('Error al reordenar cursos.');
            return;
        }
        
        // Swap the course data (but keep the IDs as they represent positions)
        const fromCourse = { ...panelState.courses[fromIndex] };
        const toCourse = { ...panelState.courses[toIndex] };
        
        // Swap all data except IDs
        panelState.courses[fromIndex] = {
            ...toCourse,
            id: fromId
        };
        panelState.courses[toIndex] = {
            ...fromCourse,
            id: toId
        };
        
        // Update both courses on the server
        updateCourseOnServer(panelState.courses[fromIndex]);
        updateCourseOnServer(panelState.courses[toIndex]);
        
        // Re-render the list
        renderCoursesList();
        
        showSuccess('Cursos reordenados correctamente.');
    }
    
    /**
     * Update a single course on the server
     */
    function updateCourseOnServer(course) {
        $.ajax({
            url: mongruasPanelAjax.resturl + `courses/${course.id}`,
            method: 'PUT',
            headers: {
                'X-WP-Nonce': mongruasPanelAjax.nonce,
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(course),
            error: function() {
                console.error('Failed to update course', course.id);
            }
        });
    }
    
    /**
     * Select a course for editing
     */
    function selectCourse(e) {
        const courseId = parseInt($(e.currentTarget).data('course-id'));
        const course = panelState.courses.find(c => c.id === courseId);
        
        if (course) {
            panelState.currentCourse = course;
            renderCourseEditor(course);
            
            // Update preview immediately (no debounce for course selection)
            const formData = getFormData();
            const previewHtml = generatePreviewHtml(formData);
            $('#preview-content').html(previewHtml);
            
            // Update active state in list
            $('.course-item').removeClass('active');
            $(e.currentTarget).addClass('active');
        }
    }
    
    /**
     * Add new course (select first empty slot)
     */
    function addNewCourse() {
        const emptyCourse = panelState.courses.find(c => !c.name);
        if (emptyCourse) {
            panelState.currentCourse = emptyCourse;
            renderCourseEditor(emptyCourse);
            
            // Update preview immediately for new course
            const formData = getFormData();
            const previewHtml = generatePreviewHtml(formData);
            $('#preview-content').html(previewHtml);
            
            // Update active state in list
            $('.course-item').removeClass('active');
            $(`.course-item[data-course-id="${emptyCourse.id}"]`).addClass('active');
            
            // Focus on name field
            setTimeout(() => {
                $('#course-name').focus();
            }, 100);
        } else {
            showError('No hay espacios disponibles para nuevos cursos.');
        }
    }
    
    /**
     * Render course editor form
     */
    function renderCourseEditor(course) {
        $('#editor-title').text(`Editando Curso ${course.id}`);
        
        const formHtml = `
            <div class="form-field">
                <label for="course-name">Nombre del Curso *</label>
                <input type="text" id="course-name" name="name" value="${escapeHtml(course.name || '')}" required>
                <div class="field-validation" id="name-validation"></div>
            </div>
            
            <div class="form-field">
                <label for="course-description">Descripción</label>
                <textarea id="course-description" name="description" rows="3">${escapeHtml(course.description || '')}</textarea>
            </div>
            
            <div class="form-row">
                <div class="form-field">
                    <label for="course-date">Fecha de Inicio</label>
                    <input type="text" id="course-date" name="date" value="${escapeHtml(course.date || '')}" placeholder="Ej: 15 de Enero 2025">
                </div>
                
                <div class="form-field">
                    <label for="course-duration">Duración</label>
                    <input type="text" id="course-duration" name="duration" value="${escapeHtml(course.duration || '')}" placeholder="Ej: 40 horas">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-field">
                    <label for="course-modality">Modalidad</label>
                    <select id="course-modality" name="modality">
                        <option value="Online" ${course.modality === 'Online' ? 'selected' : ''}>Online</option>
                        <option value="Presencial" ${course.modality === 'Presencial' ? 'selected' : ''}>Presencial</option>
                        <option value="Semipresencial" ${course.modality === 'Semipresencial' ? 'selected' : ''}>Semipresencial</option>
                    </select>
                </div>
                
                <div class="form-field">
                    <label for="course-category">Categoría</label>
                    <select id="course-category" name="category">
                        <option value="Prevención de Riesgos Laborales" ${course.category === 'Prevención de Riesgos Laborales' ? 'selected' : ''}>Prevención de Riesgos Laborales</option>
                        <option value="Formación Profesional" ${course.category === 'Formación Profesional' ? 'selected' : ''}>Formación Profesional</option>
                        <option value="Idiomas" ${course.category === 'Idiomas' ? 'selected' : ''}>Idiomas</option>
                        <option value="Informática" ${course.category === 'Informática' ? 'selected' : ''}>Informática</option>
                        <option value="Gestión Empresarial" ${course.category === 'Gestión Empresarial' ? 'selected' : ''}>Gestión Empresarial</option>
                        <option value="Marketing" ${course.category === 'Marketing' ? 'selected' : ''}>Marketing</option>
                        <option value="Otros" ${course.category === 'Otros' ? 'selected' : ''}>Otros</option>
                    </select>
                </div>
            </div>
            
            <div class="form-field">
                <label for="course-image">Imagen del Curso</label>
                <div class="image-upload-area" id="image-upload-area">
                    ${course.image && course.image.url ? 
                        `<img src="${course.image.url}" alt="Imagen del curso" class="image-preview" id="image-preview">
                         <p>Haz clic o arrastra una nueva imagen para cambiar</p>
                         <button type="button" class="btn-remove-image">Eliminar imagen</button>` :
                        `<p>Haz clic o arrastra una imagen aquí</p>
                         <p><small>Formatos: JPG, PNG, WebP (máx. 2MB)</small></p>`
                    }
                </div>
                <input type="file" id="course-image-input" accept="image/jpeg,image/jpg,image/png,image/webp" style="display: none;">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary">Guardar Curso</button>
                <button type="button" class="btn-secondary" id="delete-course-btn">Eliminar</button>
            </div>
        `;
        
        elements.courseForm.html(formHtml).show();
        
        // Bind delete button with enhanced confirmation
        $('#delete-course-btn').on('click', function() {
            showDeleteConfirmationDialog(course.id, course.name);
        });
    }
    
    /**
     * Update live preview with debouncing
     */
    function updatePreview() {
        if (!panelState.currentCourse) return;
        
        // Clear existing debounce timer
        if (panelState.previewUpdateTimer) {
            clearTimeout(panelState.previewUpdateTimer);
        }
        
        // Debounce preview updates for performance
        panelState.previewUpdateTimer = setTimeout(function() {
            const formData = getFormData();
            const previewHtml = generatePreviewHtml(formData);
            
            $('#preview-content').html(previewHtml);
        }, 150); // 150ms debounce
    }
    
    /**
     * Schedule auto-save with enhanced timing and triggers
     */
    function scheduleAutoSave() {
        // Mark as having unsaved changes
        panelState.hasUnsavedChanges = true;
        updateSaveIndicator();
        
        // Clear existing timer
        if (panelState.autoSaveTimer) {
            clearTimeout(panelState.autoSaveTimer);
        }
        
        // Get form data to determine auto-save timing
        const formData = getFormData();
        const hasRequiredFields = formData.name && formData.name.trim().length >= 3;
        const hasSubstantialContent = formData.description && formData.description.trim().length > 10;
        const hasImage = formData.image && formData.image.url;
        const hasAllBasicFields = hasRequiredFields && formData.date && formData.duration;
        
        // Enhanced timing logic based on content completeness and user activity
        let autoSaveDelay;
        if (hasAllBasicFields && hasSubstantialContent && hasImage) {
            // Very fast save for complete courses (high value content)
            autoSaveDelay = 1000;
        } else if (hasAllBasicFields && hasSubstantialContent) {
            // Fast save for courses with good content
            autoSaveDelay = 1500;
        } else if (hasRequiredFields && hasSubstantialContent) {
            // Medium-fast save for courses with name and description
            autoSaveDelay = 2500;
        } else if (hasRequiredFields) {
            // Medium save for courses with name only
            autoSaveDelay = 4000;
        } else {
            // Slow save for incomplete courses (avoid spam saves)
            autoSaveDelay = 8000;
        }
        
        // Show typing indicator immediately for better UX
        showTypingIndicator();
        
        // Schedule auto-save with enhanced error handling
        panelState.autoSaveTimer = setTimeout(function() {
            if (panelState.hasUnsavedChanges && panelState.currentCourse) {
                autoSaveCourse();
            }
        }, autoSaveDelay);
    }
    
    /**
     * Auto-save course data with enhanced error handling and retry logic
     */
    function autoSaveCourse(callback, retryCount = 0) {
        if (!panelState.currentCourse) {
            if (callback) callback();
            return;
        }
        
        const formData = getFormData();
        
        // Don't auto-save if name is empty or too short (invalid course)
        if (!formData.name.trim() || formData.name.trim().length < 3) {
            if (callback) callback();
            return;
        }
        
        // Show saving indicator with retry info if applicable
        showSavingIndicator(retryCount);
        
        // Prepare data for API
        const courseData = {
            ...formData,
            id: panelState.currentCourse.id,
            lastModified: new Date().toISOString()
        };
        
        $.ajax({
            url: mongruasPanelAjax.resturl + `courses/${panelState.currentCourse.id}`,
            method: 'PUT',
            headers: {
                'X-WP-Nonce': mongruasPanelAjax.nonce,
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(courseData),
            timeout: 10000, // 10 second timeout
            success: function(response) {
                if (response.success) {
                    // Update local state
                    const courseIndex = panelState.courses.findIndex(c => c.id === panelState.currentCourse.id);
                    if (courseIndex !== -1) {
                        panelState.courses[courseIndex] = { ...panelState.courses[courseIndex], ...formData, isActive: !!formData.name };
                        panelState.currentCourse = panelState.courses[courseIndex];
                    }
                    
                    // Mark as saved
                    panelState.hasUnsavedChanges = false;
                    renderCoursesList();
                    
                    // Show success indicator with timestamp and retry info
                    showAutoSaveSuccess(retryCount);
                    
                    // Execute callback if provided
                    if (callback) callback();
                } else {
                    // Handle server-side validation errors
                    console.warn('Auto-save failed: Server validation error', response);
                    showAutoSaveError('Error de validación del servidor');
                    if (callback) callback();
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                // Enhanced error handling with retry logic
                if (xhr.status === 401 || xhr.status === 403) {
                    // Session expired - show warning
                    showSessionExpiredWarning();
                    if (callback) callback();
                } else if (textStatus === 'timeout' || xhr.status === 0 || xhr.status >= 500) {
                    // Network timeout or server error - retry up to 2 times
                    if (retryCount < 2) {
                        console.warn(`Auto-save failed (attempt ${retryCount + 1}), retrying...`);
                        setTimeout(() => {
                            autoSaveCourse(callback, retryCount + 1);
                        }, Math.pow(2, retryCount) * 1000); // Exponential backoff: 1s, 2s
                    } else {
                        console.error('Auto-save failed after 3 attempts');
                        showAutoSaveError('Error de conexión. Cambios no guardados.');
                        if (callback) callback();
                    }
                } else {
                    // Other errors - show error but don't retry
                    console.warn('Auto-save failed: Other error', xhr.status, errorThrown);
                    showAutoSaveError('Error al guardar automáticamente');
                    if (callback) callback();
                }
            }
        });
    }
    
    /**
     * Update save indicator with enhanced visual feedback
     */
    function updateSaveIndicator() {
        let indicator = $('#save-indicator');
        if (indicator.length === 0) {
            // Create indicator if it doesn't exist
            $('#editor-title').after('<div id="save-indicator" class="save-indicator"></div>');
            indicator = $('#save-indicator');
        }
        
        if (panelState.hasUnsavedChanges) {
            // Show unsaved changes with enhanced information
            const formData = getFormData();
            const changeCount = getChangeCount(formData);
            const lastEditTime = new Date().toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit'
            });
            
            let changeText = '';
            if (changeCount > 0) {
                changeText = ` (${changeCount} cambio${changeCount !== 1 ? 's' : ''})`;
            }
            
            indicator.html(`
                <span class="unsaved">
                    <span class="unsaved-icon">●</span>
                    <span class="unsaved-text">Cambios sin guardar${changeText}</span>
                    <span class="unsaved-time">Última edición: ${lastEditTime}</span>
                </span>
            `)
                .removeClass('saving saved auto-saved typing error')
                .addClass('unsaved-changes')
                .show();
        } else {
            indicator.html('<span class="saved">✓ Guardado</span>')
                .removeClass('unsaved-changes saving typing error')
                .addClass('saved')
                .show();
            
            // Hide after 3 seconds with fade
            setTimeout(function() {
                if (indicator.hasClass('saved')) {
                    indicator.fadeOut(500);
                }
            }, 3000);
        }
    }
    
    /**
     * Show typing indicator for immediate feedback
     */
    function showTypingIndicator() {
        let indicator = $('#save-indicator');
        if (indicator.length === 0) {
            $('#editor-title').after('<div id="save-indicator" class="save-indicator"></div>');
            indicator = $('#save-indicator');
        }
        
        indicator.html('<span class="typing">✏️ Escribiendo...</span>')
            .removeClass('unsaved-changes saving saved auto-saved')
            .addClass('typing')
            .show();
        
        // Clear typing indicator after 1 second if no more changes
        setTimeout(function() {
            if (indicator.hasClass('typing')) {
                updateSaveIndicator();
            }
        }, 1000);
    }
    
    /**
     * Get count of changes made to the course
     */
    function getChangeCount(formData) {
        if (!panelState.currentCourse) return 0;
        
        let changes = 0;
        const original = panelState.currentCourse;
        
        if (formData.name !== (original.name || '')) changes++;
        if (formData.description !== (original.description || '')) changes++;
        if (formData.date !== (original.date || '')) changes++;
        if (formData.duration !== (original.duration || '')) changes++;
        if (formData.modality !== (original.modality || 'Online')) changes++;
        if (formData.category !== (original.category || 'Prevención de Riesgos Laborales')) changes++;
        
        // Check image changes
        const currentImageId = original.image ? original.image.id : null;
        const formImageId = formData.image ? formData.image.id : null;
        if (currentImageId !== formImageId) changes++;
        
        return changes;
    }
    
    /**
     * Show saving indicator
     */
    function showSavingIndicator() {
        let indicator = $('#save-indicator');
        if (indicator.length === 0) {
            $('#editor-title').after('<div id="save-indicator" class="save-indicator"></div>');
            indicator = $('#save-indicator');
        }
        
        indicator.html('<span class="saving">💾 Guardando...</span>')
            .removeClass('unsaved-changes saved auto-saved')
            .addClass('saving')
            .show();
    }
    
    /**
     * Show auto-save success with timestamp
     */
    function showAutoSaveSuccess() {
        const indicator = $('#save-indicator');
        const timestamp = new Date().toLocaleTimeString('es-ES', { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        });
        
        indicator.html(`<span class="auto-saved">✓ Guardado automáticamente (${timestamp})</span>`)
            .removeClass('unsaved-changes saving saved')
            .addClass('auto-saved')
            .show();
        
        // Hide after 4 seconds
        setTimeout(function() {
            indicator.fadeOut(500);
        }, 4000);
    }
    
    /**
     * Validate form field
     */
    function validateField($field) {
        const fieldName = $field.attr('name');
        const value = $field.val().trim();
        let isValid = true;
        let message = '';
        
        // Remove existing validation classes
        $field.removeClass('field-valid field-invalid');
        
        switch (fieldName) {
            case 'name':
                if (!value) {
                    isValid = false;
                    message = 'El nombre del curso es obligatorio';
                } else if (value.length < 3) {
                    isValid = false;
                    message = 'El nombre debe tener al menos 3 caracteres';
                } else if (value.length > 100) {
                    isValid = false;
                    message = 'El nombre no puede exceder 100 caracteres';
                } else {
                    message = '✓ Nombre válido';
                }
                break;
                
            case 'description':
                if (value && value.length > 500) {
                    isValid = false;
                    message = 'La descripción no puede exceder 500 caracteres';
                } else if (value) {
                    message = '✓ Descripción válida';
                }
                break;
                
            case 'date':
                if (value && value.length > 50) {
                    isValid = false;
                    message = 'La fecha no puede exceder 50 caracteres';
                } else if (value) {
                    message = '✓ Fecha válida';
                }
                break;
                
            case 'duration':
                if (value && value.length > 50) {
                    isValid = false;
                    message = 'La duración no puede exceder 50 caracteres';
                } else if (value) {
                    message = '✓ Duración válida';
                }
                break;
        }
        
        // Update field appearance
        if (value) { // Only show validation for non-empty fields
            $field.addClass(isValid ? 'field-valid' : 'field-invalid');
        }
        
        // Update validation message
        const validationElement = $field.siblings('.field-validation');
        if (validationElement.length && message) {
            validationElement.html(message).removeClass('validation-error validation-success')
                .addClass(isValid ? 'validation-success' : 'validation-error');
        }
        
        return isValid;
    }
    
    /**
     * Get form data
     */
    function getFormData() {
        return {
            name: $('#course-name').val() || '',
            description: $('#course-description').val() || '',
            date: $('#course-date').val() || '',
            duration: $('#course-duration').val() || '',
            modality: $('#course-modality').val() || 'Online',
            category: $('#course-category').val() || 'Prevención de Riesgos Laborales',
            image: panelState.currentCourse.image
        };
    }
    
    /**
     * Generate preview HTML that replicates frontend course display
     */
    function generatePreviewHtml(data) {
        // Handle different course states
        if (!data.name || data.name.trim() === '') {
            return generateEmptyPreview();
        }
        
        const isComplete = data.name && data.description && data.date && data.duration && data.image;
        const hasImage = data.image && data.image.url;
        
        return `
            <div class="preview-upcoming-course-card ${!isComplete ? 'preview-incomplete' : ''}">
                ${hasImage ? generateImagePreview(data) : generateNoImagePreview()}
                
                <div class="preview-course-content">
                    <div class="preview-course-header">
                        <div class="preview-course-badge">Próximamente</div>
                        ${data.category ? `<div class="preview-course-category">${escapeHtml(data.category)}</div>` : ''}
                    </div>
                    
                    ${data.date ? `
                        <div class="preview-course-date">
                            <span class="preview-date-icon">📅</span>
                            <span class="preview-date-text">${escapeHtml(data.date)}</span>
                        </div>
                    ` : ''}
                    
                    <h3 class="preview-course-title">${escapeHtml(data.name)}</h3>
                    
                    ${data.description ? `<p class="preview-course-description">${escapeHtml(data.description)}</p>` : ''}
                    
                    <div class="preview-course-details">
                        ${data.duration ? `
                            <span class="preview-detail-item">
                                <span class="preview-detail-icon">⏱️</span>
                                ${escapeHtml(data.duration)}
                            </span>
                        ` : ''}
                        ${data.modality ? `
                            <span class="preview-detail-item">
                                <span class="preview-detail-icon">💻</span>
                                ${escapeHtml(data.modality)}
                            </span>
                        ` : ''}
                    </div>
                    
                    <div class="preview-btn-reserve">
                        Solicitar Información
                    </div>
                </div>
                
                ${!isComplete ? generateIncompleteIndicator(data) : ''}
            </div>
        `;
    }
    
    /**
     * Generate empty preview state
     */
    function generateEmptyPreview() {
        return `
            <div class="preview-empty-state">
                <div class="preview-empty-icon">📝</div>
                <h4>Vista Previa del Curso</h4>
                <p>Ingresa un nombre para el curso para ver cómo se verá en el sitio web.</p>
            </div>
        `;
    }
    
    /**
     * Generate image preview section
     */
    function generateImagePreview(data) {
        return `
            <div class="preview-course-image">
                <img src="${data.image.url}" alt="${escapeHtml(data.image.alt || data.name)}" />
            </div>
        `;
    }
    
    /**
     * Generate no image preview section
     */
    function generateNoImagePreview() {
        return `
            <div class="preview-course-image preview-no-image">
                <div class="preview-image-placeholder">
                    <div class="preview-image-icon">🖼️</div>
                    <p>Sin imagen</p>
                </div>
            </div>
        `;
    }
    
    /**
     * Generate incomplete course indicator
     */
    function generateIncompleteIndicator(data) {
        const missingFields = [];
        if (!data.name) missingFields.push('Nombre');
        if (!data.description) missingFields.push('Descripción');
        if (!data.date) missingFields.push('Fecha');
        if (!data.duration) missingFields.push('Duración');
        if (!data.image || !data.image.url) missingFields.push('Imagen');
        
        if (missingFields.length === 0) return '';
        
        return `
            <div class="preview-incomplete-indicator">
                <div class="preview-incomplete-icon">⚠️</div>
                <div class="preview-incomplete-text">
                    <strong>Curso incompleto</strong>
                    <p>Faltan: ${missingFields.join(', ')}</p>
                </div>
            </div>
        `;
    }
    
    /**
     * Save course
     */
    function saveCourse(e) {
        e.preventDefault();
        
        const formData = getFormData();
        
        if (!formData.name.trim()) {
            showError('El nombre del curso es obligatorio.');
            return;
        }
        
        // Show loading state
        const submitBtn = $(e.target).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Guardando...');
        
        // Prepare data for API
        const courseData = {
            ...formData,
            id: panelState.currentCourse.id
        };
        
        $.ajax({
            url: mongruasPanelAjax.resturl + `courses/${panelState.currentCourse.id}`,
            method: 'PUT',
            headers: {
                'X-WP-Nonce': mongruasPanelAjax.nonce,
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(courseData),
            success: function(response) {
                if (response.success) {
                    // Update local state
                    const courseIndex = panelState.courses.findIndex(c => c.id === panelState.currentCourse.id);
                    if (courseIndex !== -1) {
                        panelState.courses[courseIndex] = { ...panelState.courses[courseIndex], ...formData, isActive: !!formData.name };
                        panelState.currentCourse = panelState.courses[courseIndex];
                    }
                    
                    // Clear unsaved changes
                    panelState.hasUnsavedChanges = false;
                    updateSaveIndicator();
                    
                    renderCoursesList();
                    showSuccess('Curso guardado correctamente.');
                } else {
                    showError('Error al guardar el curso.');
                }
            },
            error: function() {
                showError('Error de conexión al guardar el curso.');
            },
            complete: function() {
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    }
    
    /**
     * Delete course
     */
    function deleteCourse(courseId) {
        $.ajax({
            url: mongruasPanelAjax.resturl + `courses/${courseId}`,
            method: 'DELETE',
            headers: {
                'X-WP-Nonce': mongruasPanelAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update local state
                    const courseIndex = panelState.courses.findIndex(c => c.id === courseId);
                    if (courseIndex !== -1) {
                        panelState.courses[courseIndex] = {
                            id: courseId,
                            name: '',
                            description: '',
                            date: '',
                            duration: '',
                            modality: 'Online',
                            category: 'Prevención de Riesgos Laborales',
                            image: null,
                            isActive: false
                        };
                    }
                    
                    panelState.currentCourse = null;
                    renderCoursesList();
                    elements.courseForm.hide();
                    $('#editor-title').text('Selecciona un curso para editar');
                    $('#preview-content').html('<p style="text-align: center; color: #7f8c8d; padding: 40px;">Selecciona un curso para ver la vista previa</p>');
                    showSuccess('Curso eliminado correctamente.');
                } else {
                    showError('Error al eliminar el curso.');
                }
            },
            error: function() {
                showError('Error de conexión al eliminar el curso.');
            }
        });
    }
    
    /**
     * Handle image upload
     */
    function handleImageUpload(e) {
        const file = e.target.files[0];
        if (file) {
            handleImageFile(file);
        }
    }
    
    /**
     * Handle image file processing
     */
    function handleImageFile(file) {
        // Validate file
        if (!file.type.startsWith('image/')) {
            showError('Por favor, selecciona un archivo de imagen válido.');
            return;
        }
        
        if (file.size > 2 * 1024 * 1024) { // 2MB
            showError('La imagen es demasiado grande. Máximo 2MB.');
            return;
        }
        
        if (file.size < 1024) { // 1KB minimum
            showError('La imagen es demasiado pequeña. Mínimo 1KB.');
            return;
        }
        
        // Show upload progress
        showImageUploadProgress();
        
        // Create FormData for upload
        const formData = new FormData();
        formData.append('file', file);
        
        // Upload to server
        $.ajax({
            url: mongruasPanelAjax.resturl + 'media/upload',
            method: 'POST',
            headers: {
                'X-WP-Nonce': mongruasPanelAjax.nonce
            },
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                
                // Upload progress
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        updateImageUploadProgress(percentComplete);
                    }
                }, false);
                
                return xhr;
            },
            success: function(response) {
                if (response.success && response.data) {
                    const imageData = response.data;
                    
                    // Update preview in form
                    $('#image-upload-area').html(`
                        <img src="${imageData.url}" alt="Vista previa" class="image-preview" id="image-preview">
                        <p>Haz clic o arrastra una nueva imagen para cambiar</p>
                        <button type="button" class="btn-remove-image" onclick="removeImage()">Eliminar imagen</button>
                    `);
                    
                    // Update course data
                    if (panelState.currentCourse) {
                        panelState.currentCourse.image = {
                            id: imageData.id,
                            url: imageData.url,
                            alt: imageData.alt || panelState.currentCourse.name || 'Imagen del curso'
                        };
                        
                        // Update preview immediately for image changes
                        const formData = getFormData();
                        const previewHtml = generatePreviewHtml(formData);
                        $('#preview-content').html(previewHtml);
                        
                        scheduleAutoSave();
                    }
                    
                    showSuccess('Imagen subida correctamente.');
                } else {
                    showError('Error al subir la imagen.');
                    resetImageUploadArea();
                }
            },
            error: function(xhr) {
                let message = 'Error al subir la imagen.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.status === 413) {
                    message = 'La imagen es demasiado grande.';
                } else if (xhr.status === 415) {
                    message = 'Tipo de archivo no válido.';
                }
                
                showError(message);
                resetImageUploadArea();
            }
        });
    }
    
    /**
     * Show image upload progress
     */
    function showImageUploadProgress() {
        $('#image-upload-area').html(`
            <div class="image-upload-progress">
                <div class="upload-spinner"></div>
                <p>Subiendo imagen...</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 0%"></div>
                </div>
                <span class="progress-text">0%</span>
            </div>
        `);
    }
    
    /**
     * Update image upload progress
     */
    function updateImageUploadProgress(percent) {
        const progressFill = $('.progress-fill');
        const progressText = $('.progress-text');
        
        if (progressFill.length && progressText.length) {
            progressFill.css('width', percent + '%');
            progressText.text(Math.round(percent) + '%');
        }
    }
    
    /**
     * Reset image upload area
     */
    function resetImageUploadArea() {
        const currentImage = panelState.currentCourse && panelState.currentCourse.image;
        
        if (currentImage && currentImage.url) {
            $('#image-upload-area').html(`
                <img src="${currentImage.url}" alt="Imagen del curso" class="image-preview" id="image-preview">
                <p>Haz clic o arrastra una nueva imagen para cambiar</p>
                <button type="button" class="btn-remove-image" onclick="removeImage()">Eliminar imagen</button>
            `);
        } else {
            $('#image-upload-area').html(`
                <p>Haz clic o arrastra una imagen aquí</p>
                <p><small>Formatos: JPG, PNG, WebP (máx. 2MB)</small></p>
            `);
        }
    }
    
    /**
     * Remove image from course
     */
    function removeImage() {
        if (panelState.currentCourse) {
            panelState.currentCourse.image = null;
            resetImageUploadArea();
            updatePreview();
            scheduleAutoSave();
            showSuccess('Imagen eliminada.');
        }
    }
    
    /**
     * Show error message
     */
    function showError(message) {
        hideMessages();
        const errorHtml = `<div class="error-message">${escapeHtml(message)}</div>`;
        $('#login-error').html(errorHtml).show();
        
        // Auto-hide after 5 seconds
        setTimeout(hideMessages, 5000);
    }
    
    /**
     * Show success message
     */
    function showSuccess(message) {
        hideMessages();
        const successHtml = `<div class="success-message">${escapeHtml(message)}</div>`;
        $('#login-error').html(successHtml).show();
        
        // Auto-hide after 3 seconds
        setTimeout(hideMessages, 3000);
    }
    
    /**
     * Show session expired warning
     */
    function showSessionExpiredWarning() {
        showCustomDialog({
            title: 'Sesión Expirada',
            message: 'Tu sesión ha expirado. Necesitas volver a autenticarte para continuar.',
            type: 'warning',
            buttons: [
                {
                    text: 'Volver a Autenticar',
                    class: 'btn-primary',
                    action: function() {
                        panelState.isAuthenticated = false;
                        showLoginForm();
                        hideCustomDialog();
                    }
                }
            ]
        });
    }
    
    /**
     * Show unsaved changes dialog with enhanced options
     */
    function showUnsavedChangesDialog(action) {
        const courseName = panelState.currentCourse.name || `Curso ${panelState.currentCourse.id}`;
        const changeCount = getChangeCount(getFormData());
        const changeText = `${changeCount} cambio${changeCount !== 1 ? 's' : ''}`;
        
        let message, buttons;
        
        if (action === 'close') {
            message = `Tienes ${changeText} sin guardar en "${courseName}". ¿Qué quieres hacer?`;
            buttons = [
                {
                    text: 'Guardar y Cerrar',
                    class: 'btn-primary',
                    action: function() {
                        hideCustomDialog();
                        // Force save and then close
                        autoSaveCourse(function() {
                            closePanel();
                        });
                    }
                },
                {
                    text: 'Cerrar sin Guardar',
                    class: 'btn-secondary btn-danger',
                    action: function() {
                        panelState.hasUnsavedChanges = false;
                        hideCustomDialog();
                        closePanel();
                    }
                },
                {
                    text: 'Cancelar',
                    class: 'btn-secondary',
                    action: function() {
                        hideCustomDialog();
                    }
                }
            ];
        } else if (action === 'switch') {
            message = `Tienes ${changeText} sin guardar en "${courseName}". ¿Qué quieres hacer antes de cambiar de curso?`;
            buttons = [
                {
                    text: 'Guardar y Cambiar',
                    class: 'btn-primary',
                    action: function() {
                        hideCustomDialog();
                        // Force save and then switch
                        autoSaveCourse(function() {
                            const targetCourse = panelState.courses.find(c => c.id === panelState.pendingCourseSwitch);
                            if (targetCourse) {
                                panelState.currentCourse = targetCourse;
                                renderCourseEditor(targetCourse);
                                updatePreview();
                                $('.course-item').removeClass('active');
                                $(`.course-item[data-course-id="${targetCourse.id}"]`).addClass('active');
                            }
                            panelState.pendingCourseSwitch = null;
                        });
                    }
                },
                {
                    text: 'Cambiar sin Guardar',
                    class: 'btn-secondary btn-danger',
                    action: function() {
                        panelState.hasUnsavedChanges = false;
                        hideCustomDialog();
                        const targetCourse = panelState.courses.find(c => c.id === panelState.pendingCourseSwitch);
                        if (targetCourse) {
                            panelState.currentCourse = targetCourse;
                            renderCourseEditor(targetCourse);
                            updatePreview();
                            $('.course-item').removeClass('active');
                            $(`.course-item[data-course-id="${targetCourse.id}"]`).addClass('active');
                        }
                        panelState.pendingCourseSwitch = null;
                    }
                },
                {
                    text: 'Cancelar',
                    class: 'btn-secondary',
                    action: function() {
                        hideCustomDialog();
                        panelState.pendingCourseSwitch = null;
                    }
                }
            ];
        }
        
        showCustomDialog({
            title: 'Cambios sin Guardar',
            message: message,
            type: 'warning',
            buttons: buttons
        });
    }
    
    /**
     * Show enhanced delete confirmation dialog
     */
    function showDeleteConfirmationDialog(courseId, courseName) {
        const message = courseName 
            ? `¿Estás seguro de que quieres eliminar el curso "${courseName}"? Esta acción no se puede deshacer.`
            : `¿Estás seguro de que quieres eliminar este curso? Esta acción no se puede deshacer.`;
            
        showCustomDialog({
            title: 'Confirmar Eliminación',
            message: message,
            type: 'danger',
            buttons: [
                {
                    text: 'Sí, Eliminar',
                    class: 'btn-danger',
                    action: function() {
                        hideCustomDialog();
                        deleteCourse(courseId);
                    }
                },
                {
                    text: 'Cancelar',
                    class: 'btn-secondary',
                    action: function() {
                        hideCustomDialog();
                    }
                }
            ]
        });
    }
    
    /**
     * Show custom dialog with enhanced styling and functionality
     */
    function showCustomDialog(options) {
        // Remove existing dialog if any
        $('#custom-dialog').remove();
        
        const dialogId = 'custom-dialog';
        const typeClass = options.type ? `dialog-${options.type}` : '';
        
        let buttonsHtml = '';
        if (options.buttons && options.buttons.length > 0) {
            buttonsHtml = options.buttons.map(button => 
                `<button type="button" class="dialog-btn ${button.class || 'btn-secondary'}" data-action="${options.buttons.indexOf(button)}">${button.text}</button>`
            ).join('');
        }
        
        const dialogHtml = `
            <div id="${dialogId}" class="custom-dialog-overlay">
                <div class="custom-dialog ${typeClass}">
                    <div class="dialog-header">
                        <h3 class="dialog-title">${escapeHtml(options.title || 'Confirmación')}</h3>
                    </div>
                    <div class="dialog-body">
                        <p class="dialog-message">${escapeHtml(options.message || '')}</p>
                    </div>
                    <div class="dialog-footer">
                        ${buttonsHtml}
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(dialogHtml);
        
        // Bind button actions
        if (options.buttons) {
            options.buttons.forEach((button, index) => {
                $(`#${dialogId} .dialog-btn[data-action="${index}"]`).on('click', button.action);
            });
        }
        
        // Show with animation
        $(`#${dialogId}`).fadeIn(200);
        
        // Focus first button for keyboard navigation
        setTimeout(() => {
            $(`#${dialogId} .dialog-btn:first`).focus();
        }, 250);
        
        // ESC key to close (if cancelable)
        $(document).on('keydown.customDialog', function(e) {
            if (e.key === 'Escape') {
                const cancelButton = options.buttons && options.buttons.find(b => 
                    b.text.toLowerCase().includes('cancelar') || b.class.includes('btn-secondary')
                );
                if (cancelButton) {
                    cancelButton.action();
                }
            }
        });
    }
    
    /**
     * Hide custom dialog
     */
    function hideCustomDialog() {
        $('#custom-dialog').fadeOut(200, function() {
            $(this).remove();
        });
        $(document).off('keydown.customDialog');
    }
    
    /**
     * Hide messages
     */
    function hideMessages() {
        $('#login-error').hide();
    }
    
    /**
     * Clear login form
     */
    function clearLoginForm() {
        $('#panel-username, #panel-password').val('');
        hideMessages();
    }
    
    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    
    // Make removeImage function globally available
    window.removeImage = removeImage;
    
    /**
     * Ensure floating buttons integration
     */
    function ensureFloatingButtonsIntegration() {
        const panelAccess = document.getElementById('mongruas-panel-access');
        const floatingContainer = document.querySelector('.floating-buttons-container');
        
        if (panelAccess && floatingContainer && !floatingContainer.contains(panelAccess)) {
            console.log('🔧 Integrando botón del panel en contenedor flotante...');
            floatingContainer.insertBefore(panelAccess, floatingContainer.firstChild);
            console.log('✅ Integración completada');
        }
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        init();
        
        // Ensure integration after a short delay to allow all elements to load
        setTimeout(ensureFloatingButtonsIntegration, 100);
        
        // Also try integration when the panel is opened (fallback)
        elements.trigger.on('click', function() {
            setTimeout(ensureFloatingButtonsIntegration, 50);
        });
    });
    
})(jQuery);