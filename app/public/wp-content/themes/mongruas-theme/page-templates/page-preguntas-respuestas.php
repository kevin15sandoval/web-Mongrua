<?php
/**
 * Template Name: Preguntas y Respuestas
 * Template Post Type: page
 *
 * Página de FAQ (Preguntas Frecuentes)
 * 
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-faq">
    
    <!-- Hero -->
    <section class="page-hero faq-hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Centro de Ayuda</span>
                <h1 class="page-title">Preguntas Frecuentes</h1>
                <p class="page-subtitle">Encuentra respuestas a las dudas más comunes sobre nuestros cursos y servicios</p>
                
                <!-- Buscador de FAQ -->
                <div class="faq-search-box">
                    <input type="text" id="faqSearch" placeholder="Buscar pregunta..." />
                    <button class="btn-search">🔍</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Categorías de FAQ -->
    <section class="faq-categories-section section">
        <div class="container">
            <div class="faq-categories">
                <button class="category-btn active" data-category="all">
                    <span class="category-icon">📋</span>
                    <span>Todas</span>
                </button>
                <button class="category-btn" data-category="inscripcion">
                    <span class="category-icon">📝</span>
                    <span>Inscripción</span>
                </button>
                <button class="category-btn" data-category="cursos">
                    <span class="category-icon">📚</span>
                    <span>Cursos</span>
                </button>
                <button class="category-btn" data-category="bonificaciones">
                    <span class="category-icon">💰</span>
                    <span>Bonificaciones</span>
                </button>
                <button class="category-btn" data-category="certificados">
                    <span class="category-icon">🎓</span>
                    <span>Certificados</span>
                </button>
                <button class="category-btn" data-category="tecnico">
                    <span class="category-icon">💻</span>
                    <span>Soporte Técnico</span>
                </button>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="faq-accordion-section section" style="padding-top: 0;">
        <div class="container">
            <div class="faq-grid">

                <?php
                // Preguntas frecuentes organizadas por categoría
                $faqs = array(
                    // Inscripción
                    array(
                        'category' => 'inscripcion',
                        'question' => '¿Cómo puedo inscribirme en un curso?',
                        'answer' => 'Puedes inscribirte de varias formas: llamando al teléfono 925 82 14 14, enviando un WhatsApp, rellenando el formulario de contacto en nuestra web, o visitándonos en nuestras instalaciones en Talavera de la Reina.'
                    ),
                    array(
                        'category' => 'inscripcion',
                        'question' => '¿Qué documentación necesito para matricularme?',
                        'answer' => 'Necesitarás tu DNI/NIE, datos de contacto y, en caso de formación bonificada, los datos de tu empresa. Nosotros te guiaremos en todo el proceso y te ayudaremos con la documentación necesaria.'
                    ),
                    array(
                        'category' => 'inscripcion',
                        'question' => '¿Cuánto tiempo tarda el proceso de inscripción?',
                        'answer' => 'El proceso de inscripción es rápido y sencillo. Una vez recibida tu solicitud, te contactamos en menos de 24 horas para completar la matrícula. Si es formación bonificada, el proceso puede tardar unos días más por la tramitación con FUNDAE.'
                    ),
                    
                    // Cursos
                    array(
                        'category' => 'cursos',
                        'question' => '¿Qué tipos de cursos ofrecéis?',
                        'answer' => 'Ofrecemos más de 2000 cursos en diferentes modalidades: online, presencial y mixta. Nuestro catálogo incluye informática, idiomas, gestión empresarial, marketing, certificados de profesionalidad y formación especializada en construcción y metal.'
                    ),
                    array(
                        'category' => 'cursos',
                        'question' => '¿Cuánto dura un curso?',
                        'answer' => 'La duración varía según el curso. Tenemos cursos desde 20 horas hasta certificados de profesionalidad de más de 600 horas. En la ficha de cada curso encontrarás la duración específica.'
                    ),
                    array(
                        'category' => 'cursos',
                        'question' => '¿Puedo acceder al campus virtual 24/7?',
                        'answer' => 'Sí, nuestro campus virtual está disponible las 24 horas del día, los 7 días de la semana. Puedes estudiar a tu ritmo y en el horario que mejor te convenga.'
                    ),
                    array(
                        'category' => 'cursos',
                        'question' => '¿Los cursos tienen tutores?',
                        'answer' => 'Sí, todos nuestros cursos cuentan con tutores especializados que te acompañarán durante toda la formación. Podrás consultarles dudas a través del campus virtual, email o teléfono.'
                    ),
                    
                    // Bonificaciones
                    array(
                        'category' => 'bonificaciones',
                        'question' => '¿Qué es la formación bonificada?',
                        'answer' => 'La formación bonificada permite a las empresas formar a sus trabajadores sin coste, utilizando los créditos de formación que tienen disponibles. Todas las empresas que cotizan por formación profesional tienen derecho a estos créditos.'
                    ),
                    array(
                        'category' => 'bonificaciones',
                        'question' => '¿Cómo sé si mi empresa puede bonificar la formación?',
                        'answer' => 'Todas las empresas que tengan trabajadores en régimen general de la Seguridad Social pueden bonificar formación. Nosotros te ayudamos a consultar el crédito disponible de tu empresa de forma gratuita.'
                    ),
                    array(
                        'category' => 'bonificaciones',
                        'question' => '¿Quién gestiona la bonificación?',
                        'answer' => 'Nosotros nos encargamos de toda la gestión ante FUNDAE. Tú solo tienes que proporcionarnos los datos de la empresa y nosotros tramitamos todo el papeleo necesario.'
                    ),
                    array(
                        'category' => 'bonificaciones',
                        'question' => '¿Cuánto tarda en aplicarse la bonificación?',
                        'answer' => 'La bonificación se aplica en las cotizaciones a la Seguridad Social posteriores a la finalización del curso. El proceso completo suele tardar entre 2 y 3 meses desde que termina la formación.'
                    ),
                    
                    // Certificados
                    array(
                        'category' => 'certificados',
                        'question' => '¿Los certificados son oficiales?',
                        'answer' => 'Sí, todos nuestros certificados están acreditados por organismos oficiales. Los certificados de profesionalidad son títulos oficiales del SEPE, y el resto de cursos están avalados por entidades reconocidas.'
                    ),
                    array(
                        'category' => 'certificados',
                        'question' => '¿Cuándo recibo mi certificado?',
                        'answer' => 'Recibirás tu certificado una vez finalizado el curso y superadas las evaluaciones correspondientes. El plazo de emisión varía según el tipo de curso, pero generalmente es de 2 a 4 semanas.'
                    ),
                    array(
                        'category' => 'certificados',
                        'question' => '¿Los certificados son válidos para oposiciones?',
                        'answer' => 'Los certificados de profesionalidad y cursos oficiales sí son válidos para oposiciones. Te recomendamos consultar las bases específicas de cada convocatoria para confirmar los requisitos.'
                    ),
                    array(
                        'category' => 'certificados',
                        'question' => '¿Puedo solicitar un duplicado de mi certificado?',
                        'answer' => 'Sí, puedes solicitar un duplicado de tu certificado en cualquier momento. Contacta con nosotros y te indicaremos el procedimiento y coste si aplica.'
                    ),
                    
                    // Soporte Técnico
                    array(
                        'category' => 'tecnico',
                        'question' => '¿Qué requisitos técnicos necesito para los cursos online?',
                        'answer' => 'Necesitas un ordenador, tablet o smartphone con conexión a internet. El campus virtual funciona en cualquier navegador actualizado (Chrome, Firefox, Safari, Edge). No necesitas instalar ningún programa especial.'
                    ),
                    array(
                        'category' => 'tecnico',
                        'question' => 'No puedo acceder al campus virtual, ¿qué hago?',
                        'answer' => 'Primero verifica que estás usando las credenciales correctas. Si el problema persiste, contacta con soporte técnico en el 925 82 14 14 o envía un email a info@mogruas.com. Te ayudaremos a resolver el problema.'
                    ),
                    array(
                        'category' => 'tecnico',
                        'question' => '¿Puedo descargar el material del curso?',
                        'answer' => 'Sí, la mayoría de los materiales del curso están disponibles para descarga en formato PDF. Podrás consultarlos offline cuando lo necesites.'
                    ),
                    array(
                        'category' => 'tecnico',
                        'question' => '¿Funciona el campus en móvil?',
                        'answer' => 'Sí, nuestro campus virtual está optimizado para dispositivos móviles. Puedes acceder desde tu smartphone o tablet sin problemas.'
                    ),
                );

                foreach ($faqs as $index => $faq):
                ?>
                    <div class="faq-item" data-category="<?php echo esc_attr($faq['category']); ?>">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <h3><?php echo esc_html($faq['question']); ?></h3>
                            <span class="faq-icon">+</span>
                        </div>
                        <div class="faq-answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA de Contacto -->
    <section class="faq-contact-section section" style="background: #f8f9fa;">
        <div class="container">
            <div class="faq-contact-box">
                <div class="contact-icon">💬</div>
                <h2>¿No encuentras tu respuesta?</h2>
                <p>Estamos aquí para ayudarte. Contacta con nosotros y resolveremos todas tus dudas.</p>
                <div class="contact-methods">
                    <a href="tel:925821414" class="contact-method">
                        <span class="method-icon">📞</span>
                        <span>925 82 14 14</span>
                    </a>
                    <a href="mailto:info@mogruas.com" class="contact-method">
                        <span class="method-icon">✉️</span>
                        <span>info@mogruas.com</span>
                    </a>
                    <a href="#contact" class="contact-method">
                        <span class="method-icon">📝</span>
                        <span>Formulario de Contacto</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>

<style>
/* Hero */
.faq-hero {
    position: relative;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 50%, #003d7a 100%);
    padding: 100px 0 80px;
    overflow: hidden;
}

.faq-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
    border: 1px solid rgba(255,255,255,0.3);
}

.faq-hero .page-title {
    font-size: 56px;
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
}

.faq-hero .page-subtitle {
    font-size: 22px;
    color: rgba(255,255,255,0.95);
    max-width: 700px;
    margin: 0 auto 40px;
}

/* Buscador */
.faq-search-box {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    background: white;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.faq-search-box input {
    flex: 1;
    padding: 18px 30px;
    border: none;
    font-size: 16px;
    outline: none;
}

.faq-search-box .btn-search {
    padding: 18px 30px;
    background: #0066cc;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 20px;
    transition: background 0.3s;
}

.faq-search-box .btn-search:hover {
    background: #0052a3;
}

/* Categorías */
.faq-categories {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.category-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 30px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.category-btn:hover {
    border-color: #0066cc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,102,204,0.2);
}

.category-btn.active {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    border-color: transparent;
}

.category-icon {
    font-size: 18px;
}

/* FAQ Grid */
.faq-grid {
    max-width: 900px;
    margin: 0 auto;
}

.faq-item {
    background: white;
    margin-bottom: 15px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s;
}

.faq-item:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
}

.faq-item.hidden {
    display: none;
}

.faq-question {
    padding: 25px 30px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.3s;
}

.faq-question:hover {
    background: #f8f9fa;
}

.faq-question h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    flex: 1;
}

.faq-icon {
    width: 30px;
    height: 30px;
    background: #0066cc;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 300;
    transition: transform 0.3s;
    flex-shrink: 0;
    margin-left: 20px;
}

.faq-item.active .faq-icon {
    transform: rotate(45deg);
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.faq-item.active .faq-answer {
    max-height: 500px;
}

.faq-answer p {
    padding: 0 30px 25px;
    margin: 0;
    color: #495057;
    line-height: 1.8;
    font-size: 16px;
}

/* Contacto */
.faq-contact-box {
    background: white;
    padding: 60px 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.contact-icon {
    font-size: 80px;
    margin-bottom: 20px;
}

.faq-contact-box h2 {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.faq-contact-box p {
    font-size: 18px;
    color: #495057;
    margin-bottom: 30px;
}

.contact-methods {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.contact-method {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: #f8f9fa;
    border-radius: 30px;
    text-decoration: none;
    color: #1a1a1a;
    font-weight: 600;
    transition: all 0.3s;
}

.contact-method:hover {
    background: #0066cc;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,102,204,0.3);
}

.method-icon {
    font-size: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .faq-hero {
        padding: 60px 0 40px;
    }
    
    .faq-hero .page-title {
        font-size: 32px;
    }
    
    .faq-hero .page-subtitle {
        font-size: 18px;
    }
    
    .faq-search-box {
        border-radius: 30px;
    }
    
    .faq-search-box input {
        padding: 14px 20px;
        font-size: 14px;
    }
    
    .faq-search-box .btn-search {
        padding: 14px 20px;
    }
    
    .category-btn {
        padding: 10px 18px;
        font-size: 14px;
    }
    
    .faq-question {
        padding: 20px;
    }
    
    .faq-question h3 {
        font-size: 16px;
    }
    
    .faq-answer p {
        padding: 0 20px 20px;
        font-size: 15px;
    }
    
    .contact-methods {
        flex-direction: column;
    }
    
    .contact-method {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Toggle FAQ
function toggleFaq(element) {
    const faqItem = element.parentElement;
    const wasActive = faqItem.classList.contains('active');
    
    // Cerrar todos los FAQs
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Abrir el clickeado si no estaba activo
    if (!wasActive) {
        faqItem.classList.add('active');
    }
}

// Filtro por categoría
document.addEventListener('DOMContentLoaded', function() {
    const categoryBtns = document.querySelectorAll('.category-btn');
    const faqItems = document.querySelectorAll('.faq-item');
    const searchInput = document.getElementById('faqSearch');
    
    // Filtro por categoría
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Actualizar botones activos
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrar FAQs
            faqItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('active');
                }
            });
            
            // Limpiar búsqueda
            searchInput.value = '';
        });
    });
    
    // Búsqueda
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        // Resetear filtro de categorías
        categoryBtns.forEach(b => b.classList.remove('active'));
        categoryBtns[0].classList.add('active');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer p').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
                item.classList.remove('active');
            }
        });
    });
});
</script>
