function cpf_format(input) {
    let value = input.value;

    // Remove qualquer caractere que não seja número
    value = value.replace(/\D/g, "");

    // Limita o CPF a 11 dígitos
    value = value.substring(0, 11);

    // Adiciona pontos e hífen conforme necessário
    if (value.length > 3 && value.length <= 6) {
        value = value.replace(/(\d{3})(\d+)/, "$1.$2");
    }
    else if (value.length > 6 && value.length <= 9) {
        value = value.replace(/(\d{3})(\d{3})(\d+)/, "$1.$2.$3");
    }
    else if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d+)/, "$1.$2.$3-$4");
    }

    // Atualiza o valor do campo de entrada
    input.value = value;
}


function cnpj_format(input) {
    let value = input.value;

    // Remove qualquer caractere que não seja número
    value = value.replace(/\D/g, "");

    // Limita o CNPJ a 14 dígitos
    value = value.substring(0, 14);

    // Adiciona pontos, barra e hífen conforme necessário
    if (value.length > 2 && value.length <= 5) {
        value = value.replace(/(\d{2})(\d+)/, "$1.$2");
    }
    else if (value.length > 5 && value.length <= 8) {
        value = value.replace(/(\d{2})(\d{3})(\d+)/, "$1.$2.$3");
    }
    else if (value.length > 8 && value.length <= 12) {
        value = value.replace(/(\d{2})(\d{3})(\d{3})(\d+)/, "$1.$2.$3/$4");
    }
    else if (value.length > 12) {
        value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d+)/, "$1.$2.$3/$4-$5");
    }

    // Atualiza o valor do campo de entrada
    input.value = value;
}


function phone_format(input) {
    let value = input.value;

    value = value.replace(/\D/g, "");

    value = value.substring(0, 11);

    if (value.length > 2 && value.length <= 6) {
        value = value.replace(/(\d{2})(\d+)/, "($1) $2");
    }

    else if (value.length > 6 && value.length <= 10) {
        value = value.replace(/(\d{2})(\d{4})(\d+)/, "($1) $2-$3");
    }

    else if (value.length == 11) {
        value = value.replace(/(\d{2})(\d{1})(\d{4})(\d+)/, "($1) $2 $3-$4");
    }

    input.value = value;

    // 55 5 5555 5555
}


function password_validate(input) {
    let value = input.value;

    let char_amount = document.getElementById("char_amount");
    let number = document.getElementById("number");
    let upper_case_letter = document.getElementById("upper_case_letter");
    let lower_case_letter = document.getElementById("lower_case_letter");
    let symbol = document.getElementById("symbol");

    // Expressões regulares para cada condição
    let min_length = /.{8,}/;
    let hasDigit = /\d/;
    let has_upper_case = /[A-Z]/;
    let has_lower_case = /[a-z]/;
    let has_symbol = /[\W_]/;

    (min_length.test(value)) ? char_amount.style.color = "var(--green-1)" : char_amount.style.color = "var(--red-1)";

    (hasDigit.test(value)) ? number.style.color = "var(--green-1)" : number.style.color = "var(--red-1)";
    
    (has_upper_case.test(value)) ? upper_case_letter.style.color = "var(--green-1)" : upper_case_letter.style.color = "var(--red-1)";
    
    (has_lower_case.test(value)) ? lower_case_letter.style.color = "var(--green-1)" : lower_case_letter.style.color = "var(--red-1)";
    
    (has_symbol.test(value)) ? symbol.style.color = "var(--green-1)" : symbol.style.color = "var(--red-1)";

}


function password_confirm_validate(input) {
    let password = document.getElementById("password").value;
    let password_confirm = input.value;

    let passsword_match = document.getElementById("password_match");

    if(password_confirm == password) {
        passsword_match.innerText = "Senhas conferem.";
        passsword_match.style.color = "var(--green-1)";
    }
    else {
        passsword_match.innerText = "Senhas não conferem!";
        passsword_match.style.color = "var(--red-1)";
    }
}