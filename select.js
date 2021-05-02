document.querySelectorAll('.toggle__title').forEach(toggle => toggle.addEventListener(
    'click', 
    e => e.target.parentElement.classList.toggle('toggle_opened')
));

