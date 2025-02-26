import PageItem from './PageItem.js';
import ResponseRow from './ResponseRow.js';

export default class ResponseContent {

    constructor(content, paginationContent, userContent) {
        this.content = content;
        this.paginationContent = paginationContent;
        this.userContent = userContent;
        this.pageItem = new PageItem(this.paginationContent);
        this.responseRow = new ResponseRow(this.content);
    }

    cleanContent(element) {
        if (element) {
            while (element.firstChild) {
                element.removeChild(element.firstChild);
            }
        }
    }

    currentPage() {
        return this.currentPage;
    }

    setContent(result) {
        console.log(result);
        this.cleanContent(this.content);
        this.cleanContent(this.paginationContent);

        this.currentPage = result.songs.current_page;

        this.setUserContent(result.user);

        result.songs.links.forEach(element => {
            this.pageItem.add(element, (data) => {
                this.setContent(data);
            });
        });

        result.songs.data.forEach(element => {
            console.log("Canción recibida en la lista:", element);
            console.log("Usuario que creó la canción:", element.user_id);
            this.responseRow.add(element);
        });
        
    }

    setUserContent(user) {
        this.cleanContent(this.userContent);
        if(user === null) {
            this.setNoUserContent();
        } else {
            this.setCurrentUserContent(user);
        }
    }

    setCurrentUserContent(user) {
        console.log(user);
        let listItem = document.createElement('li');
        listItem.classList.add('nav-item', 'dropdown');
        
        let a = document.createElement('a');
        a.classList.add('nav-link', 'dropdown-toggle');
        a.setAttribute('data-bs-toggle', 'dropdown');
        
        let textNode = document.createTextNode(user.name);
        a.appendChild(textNode);
        listItem.appendChild(a);
        this.userContent.appendChild(listItem);
    
        let div = document.createElement('div');
        div.classList.add('dropdown-menu', 'dropdown-menu-end');
        
        // Crear el enlace de logout
        a = document.createElement('a');
        a.id = 'logoutLink';
        a.classList.add('dropdown-item');
        a.href = '#';  // No redirigir a una URL, sino manejar el evento en JS
        textNode = document.createTextNode('Logout');
        a.appendChild(textNode);
        div.appendChild(a);
        
        // Agregar el formulario oculto de logout
        let form = document.createElement('form');
        form.id = 'logout-form';
        form.action = '/projects/fecthProject/fetchProject/public/logout';  // La ruta de logout
        form.method = 'POST';
        form.style.display = 'none';
        
        let csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // CSRF Token
    
        form.appendChild(csrfToken);
        div.appendChild(form);
    
        // Agregar el div del menú al elemento de lista
        listItem.appendChild(div);
        this.userContent.appendChild(listItem);
    
        // Agregar el evento para el logout
        a.addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();  // Enviar el formulario
        });
    }
    

    setNoUserContent() {
        let baseUrl = window.location.origin + "/projects/fecthProject/fetchProject/public";
    
        let listItem = document.createElement('li');
        listItem.classList.add('nav-item');
    
        let aElement = document.createElement('a');
        aElement.classList.add('nav-link');
        aElement.href = baseUrl + "/login"; // Redirigir a la página de login
        let textNode = document.createTextNode('Login');
    
        aElement.appendChild(textNode);
        listItem.appendChild(aElement);
        this.userContent.appendChild(listItem);
    
        listItem = document.createElement('li');
        listItem.classList.add('nav-item');
        aElement = document.createElement('a');
        aElement.classList.add('nav-link');
        aElement.href = baseUrl + "/register"; // Redirigir a la página de registro
        textNode = document.createTextNode('Register');
    
        aElement.appendChild(textNode);
        listItem.appendChild(aElement);
        this.userContent.appendChild(listItem);
    }
    
}