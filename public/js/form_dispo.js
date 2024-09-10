document.getElementById('ajouter_dispo').addEventListener('click', function() {

    let container = document.getElementById('disponibilite_container');

    let index = container.getElementsByClassName('disponibilite_item').length;

    let newDispo = document.createElement('div');
    newDispo.classList.add('disponibilite_item');
    newDispo.innerHTML = `
        <div class="disponibilte_champs">
            <label for="str_jour_${index}">Jour disponible :</label>
            <select name="str_jour[${index}]" id="str_jour_${index}">
                <option value="lundi">Lundi</option>
                <option value="mardi">Mardi</option>
                <option value="mercredi">Mercredi</option>
                <option value="jeudi">Jeudi</option>
                <option value="vendredi">Vendredi</option>
                <option value="samedi">Samedi</option>
                <option value="dimanche">Dimanche</option>
            </select>
        </div>
        <div class="disponibilte_champs">
            <label for="time_debut_${index}">Heure de début :</label>
            <input id="time_debut_${index}" name="time_debut[${index}]" type="time" required>
        </div>
        <div class="disponibilte_champs">
            <label for="time_fin_${index}">Heure de fin :</label>
            <input id="time_fin_${index}" name="time_fin[${index}]" type="time" required>
        </div>
    `;

    container.appendChild(newDispo);
});