const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const signLink = document.querySelector('.sign-link');

signLink.onclick = () => {
    wrapper.classList.add('active');
}
loginLink.onclick = () => {
    wrapper.classList.remove('active');
}
wrapper.onclick = () => {
    wrapper.classList.add('fermer');
}


const section = document.querySelector('.section');
const loginButton = document.querySelector('.button');
const signButton = document.querySelector('.button1');
const iconClose = document.querySelector('#login-fermer')

loginButton.onclick = () => {
    section.classList.add('go');
    wrapper.classList.add('active');
}
signButton.onclick = () => {
    section.classList.add('go');
    wrapper.classList.remove('active');
    
}
iconClose.onclick = () => {
    section.classList.remove('go');
}



// changer l'icon de la password login
const ShowPass = (loginpass, logineye) =>{
    const Input = document.getElementById(loginpass),
          IconEye = document.getElementById(logineye)

    IconEye.addEventListener('click', () =>{
        // changer le pass en text
        if(Input.type === 'password'){
            Input.type = 'text'
            // change l'icon
            IconEye.classList.add('ri-eye-line')
            IconEye.classList.remove('ri-eye-off-line')
        }else{
            Input.type = 'password'
            IconEye.classList.add('ri-eye-off-line')
            IconEye.classList.remove('ri-eye-line')
        }
    })
}

ShowPass('loginPass','loginEye')
// changer l'icon de la password login










