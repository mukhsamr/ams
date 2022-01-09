<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Guardian;
use App\Http\Controllers\Operator;
use App\Http\Controllers\Admin;
use App\Http\Controllers\IdentityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Default
Route::get('/', [IdentityController::class, 'index']);

// Profil
Route::get('/profil', function () {
    return view('profil.profil');
});

// Login
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->middleware('identity')->name('login');
    Route::post('/', [LoginController::class, 'authenticate']);
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

// === Teacher ===
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
    // Home
    Route::prefix('home')->group(function () {
        Route::get('/', [Teacher\HomeController::class, 'index'])->name('teacherHome');
    });

    // Competences
    Route::prefix('competences')->group(function () {
        Route::get('/', [Teacher\CompetenceController::class, 'index']);
        Route::get('{subject}/{grade}', [Teacher\CompetenceController::class, 'index']);
        Route::post('/', [Teacher\CompetenceController::class, 'store']);
        Route::put('/', [Teacher\CompetenceController::class, 'update']);
        Route::delete('{competence}', [Teacher\CompetenceController::class, 'destroy']);
        Route::post('import', [Teacher\CompetenceController::class, 'import']);
    });

    // Journals
    Route::prefix('journals')->group(function () {
        Route::get('/', [Teacher\JournalController::class, 'index']);
        Route::get('{subject}/{subGrade}', [Teacher\JournalController::class, 'index']);
        Route::post('/', [Teacher\JournalController::class, 'store']);
        Route::put('/', [Teacher\JournalController::class, 'update']);
        Route::delete('{journal}', [Teacher\JournalController::class, 'destroy']);
        Route::post('import', [Teacher\JournalController::class, 'import']);
        Route::post('export', [Teacher\JournalController::class, 'export']);
    });

    // Scores
    Route::prefix('scores')->group(function () {
        Route::get('/', [Teacher\ScoreController::class, 'index']);
        Route::post('/', [Teacher\ScoreController::class, 'build']);
        Route::get('search', [Teacher\ScoreController::class, 'search']);
        Route::post('show', [Teacher\ScoreController::class, 'show']);
        Route::post('edit', [Teacher\ScoreController::class, 'edit']);
        Route::put('/', [Teacher\ScoreController::class, 'update']);
        Route::delete('remove', [Teacher\ScoreController::class, 'remove']);
        Route::delete('drop/{table}', [Teacher\ScoreController::class, 'drop']);
        Route::post('check/{table}', [Teacher\ScoreController::class, 'check']);
    });

    // Ledgers
    Route::prefix('ledgers')->group(function () {
        Route::get('/', [Teacher\LedgerController::class, 'index']);
        Route::post('/', [Teacher\LedgerController::class, 'show']);
        Route::post('load', [Teacher\LedgerController::class, 'load']);
        Route::put('/', [Teacher\LedgerController::class, 'update']);
    });
});

// === Guardian ===
Route::middleware(['auth', 'role:guardian'])->prefix('guardian')->group(function () {
    // Home
    Route::get('home', function () {
        return view('guardian.home.home');
    });

    // Competences
    Route::prefix('competences')->group(function () {
        Route::get('/', [Guardian\CompetenceController::class, 'index']);
        Route::get('{subject}', [Guardian\CompetenceController::class, 'index']);
    });

    // Journals
    Route::prefix('journals')->group(function () {
        Route::get('/', [Guardian\JournalController::class, 'index']);
        Route::get('{subject}', [Guardian\JournalController::class, 'index']);
        Route::post('export/{subGrade}/{subject}', [Guardian\JournalController::class, 'export']);
    });

    // Scores
    Route::prefix('scores')->group(function () {
        Route::get('/', [Guardian\ScoreController::class, 'index']);
    });

    // Ledgers
    Route::prefix('ledgers')->group(function () {
        Route::get('/', [Guardian\LedgerController::class, 'index']);
        Route::post('/', [Guardian\LedgerController::class, 'show']);
    });

    // Notes
    Route::prefix('notes')->group(function () {
        Route::get('/', [Guardian\NoteController::class, 'index']);
        Route::post('/', [Guardian\NoteController::class, 'check']);
        Route::put('/', [Guardian\NoteController::class, 'update']);
    });

    // Spirituals
    Route::prefix('spirituals')->group(function () {
        Route::get('/', [Guardian\SpiritualController::class, 'index']);
        Route::post('/', [Guardian\SpiritualController::class, 'check']);
        Route::put('/', [Guardian\SpiritualController::class, 'update']);
    });

    // Socials
    Route::prefix('socials')->group(function () {
        Route::get('/', [Guardian\SocialController::class, 'index']);
        Route::post('/', [Guardian\SocialController::class, 'check']);
        Route::put('/', [Guardian\SocialController::class, 'update']);
    });

    // Route::prefix('raports')->group(function () {
    //     Route::get('pts', function () {
    //         return view('guardian.raports.pts');
    //     });
    // });
});

// === Operator ===
Route::middleware(['auth', 'role:operator'])->group(function () {

    Route::prefix('operator')->group(function () {

        // Home
        Route::get('home', function () {
            return view('operator.home.home');
        });

        // Competences
        Route::prefix('competences')->group(function () {
            Route::get('/', [Operator\CompetenceController::class, 'index']);
            Route::get('{subject}/{grade}', [Operator\CompetenceController::class, 'index']);
        });

        // Journals
        Route::prefix('journals')->group(function () {
            Route::get('/', [Operator\JournalController::class, 'index']);
            Route::get('{subject}/{subGrade}', [Operator\JournalController::class, 'index']);
            Route::post('export/{subject}/{subGrade}', [Operator\JournalController::class, 'export']);
        });

        // Scores
        Route::prefix('scores')->group(function () {
            Route::get('/', [Operator\ScoreController::class, 'index']);
        });

        // Ledgers
        Route::prefix('ledgers')->group(function () {
            Route::get('/', [Operator\LedgerController::class, 'index']);
            Route::post('/', [Operator\LedgerController::class, 'show']);
        });
    });

    // Daftar
    Route::prefix('daftar')->group(function () {
        // Students
        Route::prefix('students')->group(function () {
            Route::get('/', [Operator\StudentVersionController::class, 'index']);
            Route::get('{subGrade}', [Operator\StudentVersionController::class, 'index']);
            Route::get('create/{subGrade}', [Operator\StudentVersionController::class, 'create']);
            Route::post('/', [Operator\StudentVersionController::class, 'store']);
            Route::delete('{student}', [Operator\StudentVersionController::class, 'destroy']);
        });

        // Guardians
        Route::prefix('guardians')->group(function () {
            Route::get('/', [Operator\GuardianController::class, 'index']);
            Route::post('/', [Operator\GuardianController::class, 'store']);
            Route::put('/', [Operator\GuardianController::class, 'update']);
            Route::delete('{id}', [Operator\GuardianController::class, 'destroy']);
        });
    });

    // Users
    Route::prefix('user')->group(function () {
        Route::get('student', [Operator\UserController::class, 'student']);
        Route::get('teacher', [Operator\UserController::class, 'teacher']);
        Route::put('/', [Operator\UserController::class, 'update']);
        Route::post('/', [Operator\UserController::class, 'store']);
        Route::delete('{user}', [Operator\UserController::class, 'destroy']);
    });
});

// === Admin ===
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Database
    Route::prefix('database')->group(function () {
        // Students
        Route::prefix('students')->group(function () {
            Route::get('/', [Admin\StudentController::class, 'index']);
            Route::get('create', [Admin\StudentController::class, 'create']);
            Route::post('/', [Admin\StudentController::class, 'store']);
            Route::get('edit/{student}', [Admin\StudentController::class, 'edit']);
            Route::put('/', [Admin\StudentController::class, 'update']);
            Route::delete('{student}', [Admin\StudentController::class, 'destroy']);
            Route::post('import', [Admin\StudentController::class, 'import']);
        });

        // Teachers
        Route::prefix('teachers')->group(function () {
            Route::get('/', [Admin\TeacherController::class, 'index']);
            Route::get('create', [Admin\TeacherController::class, 'create']);
            Route::post('/', [Admin\TeacherController::class, 'store']);
            Route::get('edit/{teacher}', [Admin\TeacherController::class, 'edit']);
            Route::put('/', [Admin\TeacherController::class, 'update']);
            Route::delete('{teacher}', [Admin\TeacherController::class, 'destroy']);
            Route::post('import', [Admin\TeacherController::class, 'import']);
        });
    });

    // Subjects
    Route::prefix('subjects')->group(function () {
        Route::get('/', [Admin\SubjectController::class, 'index']);
        Route::post('/', [Admin\SubjectController::class, 'store']);
        Route::put('/', [Admin\SubjectController::class, 'update']);
        Route::delete('{subject}', [Admin\SubjectController::class, 'destroy']);
        Route::post('import', [Admin\SubjectController::class, 'import']);
    });

    // Grades
    Route::prefix('grades')->group(function () {
        Route::get('/', [Admin\GradeController::class, 'index']);
        Route::post('/', [Admin\GradeController::class, 'store']);
        Route::delete('{grade}', [Admin\GradeController::class, 'destroy']);
    });

    // SubGrades
    Route::prefix('subGrades')->group(function () {
        Route::get('/', [Admin\SubGradeController::class, 'index']);
        Route::post('/', [Admin\SubGradeController::class, 'store']);
        Route::put('/', [Admin\SubGradeController::class, 'update']);
        Route::delete('{subGrade}', [Admin\SubGradeController::class, 'destroy']);
    });

    // Version
    Route::prefix('versions')->group(function () {
        Route::get('/', [Admin\VersionController::class, 'index'])->name('dev');
        Route::put('/', [Admin\VersionController::class, 'update']);
    });
});
