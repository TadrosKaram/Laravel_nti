<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeesController;

// Public Home
Route::get('/', fn() => view('welcome'));

// Dashboard (protected, but no auth middleware now)
Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

// Profile
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Students CRUD
Route::get('list/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

// Doctors CRUD
Route::get('list/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

// Courses CRUD
Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [CoursesController::class, 'create'])->name('courses.create');
Route::post('/courses', [CoursesController::class, 'store'])->name('courses.store');
Route::get('/courses/{id}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
Route::put('/courses/{id}', [CoursesController::class, 'update'])->name('courses.update');
Route::delete('/courses/{id}', [CoursesController::class, 'destroy'])->name('courses.destroy');

// Departments CRUD
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

// Employees CRUD
Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeesController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeesController::class, 'store'])->name('employees.store');
Route::get('/employees/{id}/edit', [EmployeesController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{id}', [EmployeesController::class, 'update'])->name('employees.update');
Route::delete('/employees/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');

// Student-specific assignment routes
Route::get('/students/register-courses', [StudentController::class, 'registerCoursesForm'])->name('students.register.courses.form');
Route::post('/students/register-courses', [StudentController::class, 'registerCourses'])->name('students.register.courses');

// Doctor-specific assignment routes
Route::get('/doctors/assign-courses', [DoctorController::class, 'assignCoursesForm'])->name('doctors.assign.courses.form');
Route::post('/doctors/assign-courses', [DoctorController::class, 'assignCourses'])->name('doctors.assign.courses');
Route::get('/doctors/assign-departments', [DoctorController::class, 'assignDepartmentsForm'])->name('doctors.assign.departments.form');
Route::post('/doctors/assign-departments', [DoctorController::class, 'assignDepartments'])->name('doctors.assign.departments');

// Employee-specific assignment routes
Route::get('/employees/assign-departments', [EmployeesController::class, 'assignDepartmentsForm'])->name('employees.assign.departments.form');
Route::post('/employees/assign-departments', [EmployeesController::class, 'assignDepartments'])->name('employees.assign.departments');

// General assignment routes (admin)
Route::get('/assignments/student-courses', [StudentController::class, 'assignCoursesForm'])->name('assignments.student.courses.form');
Route::post('/assignments/student-courses', [StudentController::class, 'assignCourses'])->name('assignments.student.courses');
Route::get('/assignments/doctor-courses', [DoctorController::class, 'assignCoursesFormAdmin'])->name('assignments.doctor.courses.form');
Route::post('/assignments/doctor-courses', [DoctorController::class, 'assignCoursesAdmin'])->name('assignments.doctor.courses');
Route::get('/assignments/doctor-departments', [DoctorController::class, 'assignDepartmentsFormAdmin'])->name('assignments.doctor.departments.form');
Route::post('/assignments/doctor-departments', [DoctorController::class, 'assignDepartmentsAdmin'])->name('assignments.doctor.departments');
Route::get('/assignments/employee-departments', [EmployeesController::class, 'assignDepartmentsFormAdmin'])->name('assignments.employee.departments.form');
Route::post('/assignments/employee-departments', [EmployeesController::class, 'assignDepartmentsAdmin'])->name('assignments.employee.departments'); 