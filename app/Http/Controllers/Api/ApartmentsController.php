<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ApartmentsController extends Controller
{

    /* FUNZIONE PER TUTTI GLI APPARTMENTI */
    public function index(Request $request)
    {

        /* CREO UNA QUERY PER GLI APPARTIMENTI */
        $query = Apartment::query();


        /* METTO IN ORDINE PER DATA DI CREAZIONE GLI APPARTAMENTI E PASSO I SERVIZI RELAZIONATI TRAMITE MODELLO */
        $apartments = $query->latest()->with('services')->get();


        /* RESTITUISCO I DATI DEGLI APPARTAMENTI IN JSON */
        return response()->json($apartments);
    }


    /* FUNZIONE PER SINGOLO APPARTAMENTO */
    public function show(string $id)
    {

        /* RECUPERO L'APPARTMENTO CON ID SPECIFICO, E PASSO I SERVIZI CORRELLATI */
        $apartment = Apartment::with('services')->find($id);
        /* MESSAGGIO DI 404 SE L'APPARTMANETO NON ESISTE */
        if (!$apartment) return response(null, 404);

        // Verifica se esiste una visita dell'IP per questo appartamento nelle ultime 24 ore
        $ip = request()->ip();
        $lastVisit = View::where('apartment_id', $apartment->id)
            ->where('code_ip', $ip)
            ->latest()
            ->first();

        if (!$lastVisit || $lastVisit->created_at->diffInDays(Carbon::now()) >= 1) {
            // Se non esiste una visita precedente o è passato un giorno dall'ultima visita, crea una nuova visita
            View::create([
                'apartment_id' => $apartment->id,
                'code_ip' => $ip
            ]);
        }

        // Aggiorna la data dell'ultima visita
        if ($lastVisit) {
            $lastVisit->update(['created_at' => Carbon::now()]);
        }


        /* RESTITUISCO I DATI DELL'APPARTAMENTO SPECIFICO IN JSON */
        return response()->json($apartment);
        // return response()->json([
        //     'apartment' => $apartment,
        //     'last_visit' => $lastVisit
        // ]);
    }
}
