const termsContent = document.getElementById("terms-content");

fetch('js/json/terms_conditions.json')
    .then(response => response.json())
    .then(jsonContent => {
        jsonContent.sections.forEach(section => {
            const sectionDiv = document.createElement("div");
            sectionDiv.className = "terms-content__group";

            const sectionTitle = document.createElement("h1");
            sectionTitle.textContent = section.title;

            const sectionContent = document.createElement("p");
            sectionContent.textContent = section.content;

            sectionDiv.appendChild(sectionTitle);
            sectionDiv.appendChild(sectionContent);

            termsContent.appendChild(sectionDiv);
        });

        const lastUpdated = document.createElement("div");
        lastUpdated.className = "terms-content__update";
        lastUpdated.innerHTML = `<p>Ultima actualizare: ${jsonContent.last_updated}</p>`;

        termsContent.appendChild(lastUpdated);
    })
    .catch(error => {
        console.error('Error fetching JSON:', error);
    });