document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.connexion_form');

    form.addEventListener('submit', function(event) {
        let isValid = true;
        let errorMessage = '';

        const email = document.getElementById('str_email').value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            isValid = false;
            errorMessage += 'Veuillez entrer une adresse email valide.\n';
        }

        const nom = document.getElementById('str_nom').value;
        if (nom.trim() === '') {
            isValid = false;
            errorMessage += 'Le champ "nom" est obligatoire.\n';
        }

        const prenom = document.getElementById('str_prenom').value;
        if (prenom.trim() === '') {
            isValid = false;
            errorMessage += 'Le champ "prénom" est obligatoire.\n';
        }

        const pseudo = document.getElementById('str_pseudo').value;
        if (pseudo.trim() === '') {
            isValid = false;
            errorMessage += 'Le champ "pseudo" est obligatoire.\n';
        }

        const dateNaissance = document.getElementById('dtm_naissance').value;
        const dateNaissancePattern = /^\d{4}-\d{2}-\d{2}$/;
        if (!dateNaissancePattern.test(dateNaissance)) {
            isValid = false;
            errorMessage += 'Veuillez entrer une date de naissance valide (YYYY-MM-DD).\n';
        } else {
            const birthDate = new Date(dateNaissance);
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 0) {
                isValid = false;
                errorMessage += 'La date de naissance ne peut pas être dans le futur.\n';
            }
        }

        if (!isValid) {
            alert(errorMessage);
            event.preventDefault();
        }
    });
});
