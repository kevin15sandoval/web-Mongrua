import { create } from 'zustand';

// Courses Store
export const useCoursesStore = create((set, get) => ({
  courses: [],
  selectedCourse: null,
  loading: false,
  error: null,

  setCourses: courses => set({ courses }),
  setSelectedCourse: course => set({ selectedCourse: course }),
  setLoading: loading => set({ loading }),
  setError: error => set({ error }),

  addCourse: course => set(state => ({ courses: [...state.courses, course] })),
  updateCourse: updatedCourse =>
    set(state => ({
      courses: state.courses.map(course =>
        course.id === updatedCourse.id ? updatedCourse : course
      ),
    })),
  removeCourse: courseId =>
    set(state => ({
      courses: state.courses.filter(course => course.id !== courseId),
    })),
}));
