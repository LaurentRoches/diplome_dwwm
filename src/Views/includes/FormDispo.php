<form method="post" action="save_availability.php">
    <h3>Indiquez vos disponibilités</h3>

    <label for="jour">Jour de la semaine:</label>
    <select name="jour" id="jour" required>
        <option value="lundi">Lundi</option>
        <option value="mardi">Mardi</option>
        <option value="mercredi">Mercredi</option>
        <option value="jeudi">Jeudi</option>
        <option value="vendredi">Vendredi</option>
        <option value="samedi">Samedi</option>
        <option value="dimanche">Dimanche</option>
    </select>

    <label for="time_debut">Heure de début:</label>
    <input type="time" name="time_debut" id="time_debut" required>

    <label for="time_fin">Heure de fin:</label>
    <input type="time" name="time_fin" id="time_fin" required>

    <button type="button" id="add">Ajouter une autre plage horaire</button>
    
    <div id="additional_slots"></div>

    <button type="submit">Enregistrer</button>
</form>

<script>
    document.getElementById('add').addEventListener('click', function() {
        const additionalSlots = document.getElementById('additional_slots');
        const newSlot = `
            <div class="time-slot">
                <label for="jour">Jour de la semaine:</label>
                <select name="jour[]" required>
                    <option value="lundi">Lundi</option>
                    <option value="mardi">Mardi</option>
                    <option value="mercredi">Mercredi</option>
                    <option value="jeudi">Jeudi</option>
                    <option value="vendredi">Vendredi</option>
                    <option value="samedi">Samedi</option>
                    <option value="dimanche">Dimanche</option>
                </select>

                <label for="time_debut">Heure de début:</label>
                <input type="time" name="time_debut[]" required>

                <label for="time_fin">Heure de fin:</label>
                <input type="time" name="time_fin[]" required>

                <button type="button" class="remove-slot">Retirer</button>
            </div>
        `;
        additionalSlots.insertAdjacentHTML('beforeend', newSlot);

        const removeButtons = document.querySelectorAll('.remove-slot');
        removeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    });
</script>
