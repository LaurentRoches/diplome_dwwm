<form method="post" action="save_availability.php">
    <h3>Indiquez vos disponibilités</h3>

    <label for="day">Jour de la semaine:</label>
    <select name="day" id="day" required>
        <option value="lundi">Lundi</option>
        <option value="mardi">Mardi</option>
        <option value="mercredi">Mercredi</option>
        <option value="jeudi">Jeudi</option>
        <option value="vendredi">Vendredi</option>
        <option value="samedi">Samedi</option>
        <option value="dimanche">Dimanche</option>
    </select>

    <label for="start_time">Heure de début:</label>
    <input type="time" name="start_time" id="start_time" required>

    <label for="end_time">Heure de fin:</label>
    <input type="time" name="end_time" id="end_time" required>

    <button type="button" id="add">Ajouter une autre plage horaire</button>
    
    <div id="additional_slots"></div>

    <button type="submit">Enregistrer</button>
</form>

<script>
    document.getElementById('add').addEventListener('click', function() {
        const additionalSlots = document.getElementById('additional_slots');
        const newSlot = `
            <div class="time-slot">
                <label for="day">Jour de la semaine:</label>
                <select name="day[]" required>
                    <option value="lundi">Lundi</option>
                    <option value="mardi">Mardi</option>
                    <option value="mercredi">Mercredi</option>
                    <option value="jeudi">Jeudi</option>
                    <option value="vendredi">Vendredi</option>
                    <option value="samedi">Samedi</option>
                    <option value="dimanche">Dimanche</option>
                </select>

                <label for="start_time">Heure de début:</label>
                <input type="time" name="start_time[]" required>

                <label for="end_time">Heure de fin:</label>
                <input type="time" name="end_time[]" required>

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
