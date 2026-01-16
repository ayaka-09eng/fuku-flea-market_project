document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    let preview = document.getElementById('preview');
    const label = document.getElementById('imageLabel');
    const deleteBtn = document.getElementById('imageDelete');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {

            if (preview.tagName.toLowerCase() === 'div') {
                const img = document.createElement('img');
                img.id = 'preview';
                img.className = preview.dataset.previewClass;
                img.alt = preview.getAttribute('aria-label') || '';
                preview.replaceWith(img);
                preview = img;
            }

            preview.src = e.target.result;
            preview.classList.remove('profile-create__avatar--noimg');
            preview.classList.remove('profile-edit__avatar--noimg');

            preview.classList.remove('sell-form__img--hidden');
            label.classList.add('sell-form__image-label--hidden');
            deleteBtn.classList.remove('sell-form__image-delete--hidden');
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('imageDelete').addEventListener('click', function() {
    const preview = document.getElementById('preview');
    const label = document.getElementById('imageLabel');
    const input = document.getElementById('imageInput');
    const deleteBtn = document.getElementById('imageDelete');

    preview.src = "";
    preview.classList.add('sell-form__img--hidden');
    label.classList.remove('sell-form__image-label--hidden');
    deleteBtn.classList.add('sell-form__image-delete--hidden');
    input.value = "";
});
