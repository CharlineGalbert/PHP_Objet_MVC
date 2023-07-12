const inputs = document.querySelectorAll('input[type="file"]');
const img = document.querySelector('form .img-form-preview');

if(img && inputs){
    inputs.forEach(input => {
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();  // FileReader = class native à JS qui permet de lire ce qu'il y a dans un fichier
            
            reader.readAsDataURL(file);

            reader.onloadend = () => {
                img.src = reader.result;
            }
        });
    });
}
// console.error(inputs, img);