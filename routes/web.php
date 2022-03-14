<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Guardian;
use App\Http\Controllers\Operator;
use App\Http\Controllers\Admin;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/', function () {
    $level = auth()->user()->level;
    if ($level === '0') {
        $route = 'dev';
    } elseif ($level == 1) {
        $route = 'studentHome';
    } else {
        $route = 'teacherHome';
    }

    return redirect(route($route));
})->middleware('auth', 'identity', 'attendance');

// Profil
Route::prefix('profil')->group(function () {
    Route::get('/', [ProfileController::class, 'teacher']);
});

// Attendance
Route::middleware(['auth', 'identity', 'attendance'])->prefix('attendance')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('student', [AttendanceController::class, 'student']);
    Route::get('teacher', [AttendanceController::class, 'teacher']);
    Route::put('/', [AttendanceController::class, 'update']);
    Route::post('qrcode', [AttendanceController::class, 'qrcode']);
    Route::post('barcode', [AttendanceController::class, 'barcode']);
});

// Setting
Route::prefix('setting')->group(function () {
    Route::get('/', [SettingController::class, 'index']);
    Route::get('teacher', [SettingController::class, 'teacher']);
    Route::put('/', [SettingController::class, 'update']);
});

// Login
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->middleware('guest')->name('login');
    Route::post('/', [LoginController::class, 'authenticate']);
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

// Raport
Route::prefix('raport')->group(function () {
    Route::post('ptsPDF', [RaportController::class, 'ptsPDF']);
});

// =======


// === Teacher ===
Route::middleware(['auth', 'identity', 'attendance', 'role:teacher'])->prefix('teacher')->group(function () {
    // Home
    Route::prefix('home')->group(function () {
        Route::get('/', [Teacher\HomeController::class, 'index'])->name('teacherHome');
    });

    // Competences
    Route::prefix('competences')->group(function () {
        Route::get('/', [Teacher\CompetenceController::class, 'index']);
        Route::post('/', [Teacher\CompetenceController::class, 'store']);
        Route::get('edit/{id}', [Teacher\CompetenceController::class, 'edit']);
        Route::put('/', [Teacher\CompetenceController::class, 'update']);
        Route::delete('{competence}', [Teacher\CompetenceController::class, 'destroy']);
        Route::post('import', [Teacher\CompetenceController::class, 'import']);
    });

    // Journals
    Route::prefix('journals')->group(function () {
        Route::get('/', [Teacher\JournalController::class, 'index']);
        Route::get('create', [Teacher\JournalController::class, 'create']);
        Route::post('/', [Teacher\JournalController::class, 'store']);
        Route::get('edit/{id}', [Teacher\JournalController::class, 'edit']);
        Route::put('/', [Teacher\JournalController::class, 'update']);
        Route::delete('{journal}', [Teacher\JournalController::class, 'destroy']);
        Route::post('import', [Teacher\JournalController::class, 'import']);
        Route::post('export', [Teacher\JournalController::class, 'export']);
    });

    // Scores
    Route::prefix('scores')->group(function () {
        Route::get('/', [Teacher\ScoreController::class, 'index']);
        Route::get('create', [Teacher\ScoreController::class, 'create']);
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

    Route::get('calendars', [Teacher\CalendarController::class, 'index']);
});

// === Guardian ===
Route::middleware(['auth', 'identity', 'attendance', 'role:guardian'])->prefix('guardian')->group(function () {
    // Home
    Route::prefix('home')->group(function () {
        Route::get('/', [Guardian\HomeController::class, 'index']);
        Route::get('{subject}', [Guardian\HomeController::class, 'info']);
    });

    // Competences
    Route::prefix('competences')->group(function () {
        Route::get('/', [Guardian\CompetenceController::class, 'index']);
        Route::get('edit/{id}', [Guardian\CompetenceController::class, 'edit']);
    });

    // Journals
    Route::prefix('journals')->group(function () {
        Route::get('/', [Guardian\JournalController::class, 'index']);
        Route::get('edit/{id}', [Guardian\JournalController::class, 'edit']);
        Route::post('export', [Guardian\JournalController::class, 'export']);
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
        Route::get('edit/{id}', [Guardian\NoteController::class, 'edit']);
        Route::post('/', [Guardian\NoteController::class, 'check']);
        Route::put('/', [Guardian\NoteController::class, 'update']);
    });

    // Spirituals
    Route::prefix('spirituals')->group(function () {
        Route::get('/', [Guardian\SpiritualController::class, 'index']);
        Route::get('edit/{id}', [Guardian\SpiritualController::class, 'edit']);
        Route::post('/', [Guardian\SpiritualController::class, 'check']);
        Route::put('/', [Guardian\SpiritualController::class, 'update']);
    });

    // Socials
    Route::prefix('socials')->group(function () {
        Route::get('/', [Guardian\SocialController::class, 'index']);
        Route::get('edit/{id}', [Guardian\SocialController::class, 'edit']);
        Route::post('/', [Guardian\SocialController::class, 'check']);
        Route::put('/', [Guardian\SocialController::class, 'update']);
    });

    // Ekskuls
    Route::prefix('ekskuls')->group(function () {
        Route::get('/', [Guardian\EkskulController::class, 'index']);
        Route::get('edit/{id}', [Guardian\EkskulController::class, 'edit']);
        Route::post('/', [Guardian\EkskulController::class, 'check']);
        Route::put('/', [Guardian\EkskulController::class, 'update']);
    });

    // Attendance
    Route::prefix('attendance')->group(function () {
        Route::get('/', [Guardian\AttendanceController::class, 'index']);
    });

    // Students
    Route::prefix('students')->group(function () {
        Route::get('/', [Guardian\StudentController::class, 'index']);
    });

    // Raports
    Route::prefix('raports')->group(function () {
        Route::get('pts', [Guardian\RaportController::class, 'pts']);
        Route::get('k13', [Guardian\RaportController::class, 'k13']);
        Route::put('setting', [Guardian\RaportController::class, 'setting'])->name('raport_setting');
        Route::post('pts_pdf', [Guardian\RaportController::class, 'pdf_pts'])->name('raport_pts_pdf');
        Route::post('k13_pdf', [Guardian\RaportController::class, 'pdf_k13'])->name('raport_k13_pdf');
    });

    // Ledger Kelas
    Route::prefix('gradeLedger')->group(function () {
        Route::get('/', [Guardian\GradeLedger::class, 'index']);
    });
});

// === Operator ===
Route::middleware(['auth', 'identity', 'attendance', 'role:operator'])->group(function () {

    Route::prefix('operator')->group(function () {

        // Home
        Route::prefix('home')->group(function () {
            Route::get('/', [Operator\HomeController::class, 'index']);
            Route::get('{subGrade}/{subject}', [Operator\HomeController::class, 'info']);
        });

        // Competences
        Route::prefix('competences')->group(function () {
            Route::get('/', [Operator\CompetenceController::class, 'index']);
            Route::get('edit/{id}', [Operator\CompetenceController::class, 'edit']);
        });

        // Journals
        Route::prefix('journals')->group(function () {
            Route::get('/', [Operator\JournalController::class, 'index']);
            Route::get('edit/{id}', [Operator\JournalController::class, 'edit']);
            Route::post('export', [Operator\JournalController::class, 'export']);
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

        // Attendance
        Route::prefix('attendance')->group(function () {
            Route::get('student', [Operator\AttendanceController::class, 'student']);
            Route::get('teacher', [Operator\AttendanceController::class, 'teacher']);
            Route::post('setting', [Operator\AttendanceController::class, 'setting']);
            Route::get('qrcode/{type}', [Operator\AttendanceController::class, 'qrcode']);
            Route::put('qrcode/{type}', [Operator\AttendanceController::class, 'updateQrcode']);
            Route::put('/', [Operator\AttendanceController::class, 'update']);
            Route::post('student/export', [Operator\AttendanceController::class, 'studentExport']);
            Route::post('teacher/export', [Operator\AttendanceController::class, 'teacherExport']);
        });

        // Raports
        Route::prefix('raports')->group(function () {
            Route::get('pts', [Operator\RaportController::class, 'pts']);
            Route::get('k13', [Operator\RaportController::class, 'k13']);
        });

        // Ledger Kelas
        Route::prefix('gradeLedger')->group(function () {
            Route::get('/', [Operator\GradeLedger::class, 'index']);
        });
    });

    // Daftar
    Route::prefix('daftar')->group(function () {
        // Students
        Route::prefix('students')->group(function () {
            Route::get('/', [Operator\StudentVersionController::class, 'index']);
            Route::get('create/{id}', [Operator\StudentVersionController::class, 'create']);
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

    // Calendar
    Route::prefix('calendar')->group(function () {
        Route::get('/', [Operator\CalendarController::class, 'index'])->name('calendar');
        Route::post('api', [Operator\CalendarController::class, 'api']);
        Route::post('/', [Operator\CalendarController::class, 'store']);
        Route::put('/', [Operator\CalendarController::class, 'update']);
        Route::delete('{calendar}', [Operator\CalendarController::class, 'destroy']);
    });

    // Users
    Route::prefix('user')->group(function () {
        Route::get('student', [Operator\UserController::class, 'student']);
        Route::get('student/create', [Operator\UserController::class, 'studentCreate']);
        Route::get('student/edit/{id}', [Operator\UserController::class, 'studentEdit']);

        Route::get('teacher', [Operator\UserController::class, 'teacher']);
        Route::get('teacher/create', [Operator\UserController::class, 'teacherCreate']);
        Route::get('teacher/edit/{id}', [Operator\UserController::class, 'teacherEdit']);

        Route::put('/', [Operator\UserController::class, 'update']);
        Route::post('/', [Operator\UserController::class, 'store']);
        Route::delete('{user}', [Operator\UserController::class, 'destroy']);
    });
});

// === Admin ===
Route::middleware(['auth', 'identity', 'attendance', 'role:admin'])->group(function () {

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

    // Lists
    Route::prefix('lists')->group(function () {
        // Spiritual
        Route::get('spiritual', [Admin\ListController::class, 'spiritual']);
        Route::post('spiritual', [Admin\ListController::class, 'spiritualStore'])->name('spiritual_store');
        Route::put('spiritual', [Admin\ListController::class, 'spiritualUpdate'])->name('spiritual_put');
        Route::delete('spiritual/{spiritual}', [Admin\ListController::class, 'spiritualDestroy'])->name('spiritual_delete');

        // Social
        Route::get('social', [Admin\ListController::class, 'social']);
        Route::post('social', [Admin\ListController::class, 'socialStore'])->name('social_store');
        Route::put('social', [Admin\ListController::class, 'socialUpdate'])->name('social_put');
        Route::delete('social/{social}', [Admin\ListController::class, 'socialDestroy'])->name('social_delete');

        // Ekskul
        Route::get('ekskul', [Admin\ListController::class, 'ekskul']);
        Route::post('ekskul', [Admin\ListController::class, 'ekskulStore'])->name('ekskul_store');
        Route::put('ekskul', [Admin\ListController::class, 'ekskulUpdate'])->name('ekskul_put');
        Route::delete('ekskul/{ekskul}', [Admin\ListController::class, 'ekskulDestroy'])->name('ekskul_delete');
    });

    // Version
    Route::prefix('versions')->group(function () {
        Route::get('/', [Admin\VersionController::class, 'index'])->name('dev');
        Route::put('/', [Admin\VersionController::class, 'update']);
    });

    // School
    Route::prefix('school')->group(function () {
        Route::get('/', [Admin\SchoolController::class, 'index']);
        Route::put('school', [Admin\SchoolController::class, 'school'])->name('school_setting');
        Route::put('headmaster', [Admin\SchoolController::class, 'headmaster'])->name('headmaster_setting');
    });
});

// === Other ===

// Clear cache
Route::get('cache-clear', function () {
    Artisan::call('cache:clear');
    return back();
});

// Symlink
Route::get('symlink', function () {
    symlink('/home/annahl/annahl/storage/app/public', '/home/annahl/public_html/storage');
});
