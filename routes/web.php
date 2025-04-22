<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\DocumentSenderController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Companies
    Route::resource('companies', CompanyController::class);
    
    // Customers
    Route::resource('customers', CustomerController::class);
    
    // Leads
    Route::resource('leads', LeadController::class);
    Route::post('/leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');
    
    // Communications
    Route::resource('communications', CommunicationController::class);
    
    // Tasks
    Route::resource('tasks', TaskController::class);
    
    // Sales
    Route::resource('sales', SaleController::class);

    // Calendar & Appointments
    Route::get('/calendar', [AppointmentController::class, 'index'])->name('calendar.index');
    Route::resource('appointments', AppointmentController::class)->except(['index']);
    
    // Email functionality
    Route::get('/emails/compose', [EmailController::class, 'compose'])->name('emails.compose');
    Route::post('/emails/send', [EmailController::class, 'send'])->name('emails.send');
    
    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.pdf');
    Route::get('/invoices/{invoice}/send', [DocumentSenderController::class, 'showSendInvoiceForm'])->name('invoices.send.form');
    Route::post('/invoices/{invoice}/send', [DocumentSenderController::class, 'sendInvoice'])->name('invoices.send');
    Route::post('/invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-as-paid');
    
    // Quotes
    Route::resource('quotes', QuoteController::class);
    Route::get('/quotes/{quote}/pdf', [QuoteController::class, 'generatePdf'])->name('quotes.pdf');
    Route::get('/quotes/{quote}/send', [DocumentSenderController::class, 'showSendQuoteForm'])->name('quotes.send.form');
    Route::post('/quotes/{quote}/send', [DocumentSenderController::class, 'sendQuote'])->name('quotes.send');
    Route::post('/quotes/{quote}/convert-to-invoice', [QuoteController::class, 'convertToInvoice'])->name('quotes.convert');
    
    // Activity Logs
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
