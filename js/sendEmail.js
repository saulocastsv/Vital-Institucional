
document.getElementById("form").addEventListener("submit", function (event) {
    event.preventDefault();

    var input = document.querySelector('input[type="file"]')
    var name = document.getElementById("name").value
    var email = document.getElementById("email").value
    var phone = document.getElementById("phone").value
    var message = document.getElementById("message").value
    var subject = document.getElementById("subject").value

    var formBtn = document.getElementById("formBtn")


    const emails = {
        orcamento: "compras@vitalscheffer.com.br",
        duvida: "vendas05@vitalscheffer.com.br",
        vagadeemprego: "rh@vitalscheffer.com.br"
    }

    if (emails[subject] == undefined) {
        emails[subject] = "vendas05@vitalscheffer.com.br"
    }

    const currentUrl = (window.location.href).replace("contact.html", "").replace("index.html", "").replace("sac.html", "")

    var data = new FormData()

    if (input) {
        data.append('file', input.files[0])
    }

    data.append('name', name)
    data.append('email', email)
    data.append('phone', phone)
    data.append('message', message)
    data.append('subject', subject)
    data.append('emailreceiver', emails[subject])

    const options = {
        method: 'POST',
        body: data
    };

    formBtn.disabled = true;
    formBtn.innerText = "Enviando...";

    fetch(currentUrl + 'mail/mail.php', options)
        .then(response => response.json())
        .then(data => {
            console.log(data)
            Swal.fire({
                text: 'Email enviado com sucesso!',
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'

            });
            formBtn.innerText = "Enviado";
            formBtn.disabled = false;
            return
        })
        .catch(err => {
            console.error('Error:', err);

            Swal.fire({
                text: 'Não foi possível enviar o email.',
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });
            formBtn.innerText = "Enviado";
            formBtn.disabled = false;
            return

        });
    formBtn.innerText = "Enviar";
});
// Chamar a função com JavaScript

