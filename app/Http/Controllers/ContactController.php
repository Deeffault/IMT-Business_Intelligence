<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Contact', [
            'message' => session('message'),
            'error' => session('error'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_size' => 'required|in:micro,small,medium,large',
            'sector' => 'required|string|max:255',
            'current_score' => 'nullable|numeric|min:0|max:100',
            'improvement_goals' => 'required|string|max:1000',
            'budget_range' => 'required|in:5000-15000,15000-50000,50000-100000,100000+',
            'timeline' => 'required|in:immediate,1-3months,3-6months,6-12months',
            'message' => 'nullable|string|max:2000',
        ]);

        try {
            // Sauvegarder la demande en base de données
            $contactRequest = ContactRequest::create($validated);

            // Ici vous pouvez envoyer un email, etc.
            // Exemple d'envoi d'email (décommentez si vous avez configuré Mail)
            /*
            Mail::send('emails.contact-request', $validated, function ($message) use ($validated) {
                $message->to('contact@votre-entreprise.com')
                        ->subject('Nouvelle demande d\'amélioration de score RSE - ' . $validated['company_name']);
            });
            */

            return redirect()->route('contact.show')->with('message', [
                'type' => 'success',
                'title' => 'Demande envoyée avec succès !',
                'content' => 'Nous avons bien reçu votre demande d\'amélioration de score RSE. Notre équipe vous contactera dans les 24-48h pour discuter de vos besoins.',
            ]);

        } catch (\Exception $e) {
            return redirect()->route('contact.show')->with('error', [
                'type' => 'error',
                'title' => 'Erreur lors de l\'envoi',
                'content' => 'Une erreur est survenue lors de l\'envoi de votre demande. Veuillez réessayer ou nous contacter directement.',
            ]);
        }
    }
}
