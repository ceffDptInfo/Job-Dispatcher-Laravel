<?php 

namespace App\Http\Controllers;


class JobController extends Controller
{ 
    // function sauvegarderDansLaravel(fichierBinaire) {
    //     // On prépare un faux formulaire pour envoyer le fichier
    //     let formulaire = new FormData();
    //     let blob = new Blob([fichierBinaire], { type: "application/octet-stream" });
        
    //     formulaire.append("file", blob, "piece_orientee.stl");
    //     formulaire.append("_token", "{{ csrf_token() }}"); // Sécurité Laravel

    //     // On l'envoie à ta route Laravel
    //     fetch("/jobs/12/update-stl", {
    //         method: "POST",
    //         body: formulaire
    //     }).then(response => {
    //         alert("Pièce sauvegardée avec succès !");
    //     });
    // }
}