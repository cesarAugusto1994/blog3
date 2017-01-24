/**
 * Created by cesar on 03/11/16.
 */

var style = {
    padding: "0",
    backgroundImage: 'url(' + $("#register").data("dir-img") + $("#register").data("background") + ')'
};

const StyleForm = {
    backgroundColor: "transparent"
};

var Register = React.createClass({displayName: "Register",

    render: function () {

        return (
            React.createElement("section", {id: "hero-area", style: style}, 
                React.createElement("div", {className: "container"}, 
                    React.createElement("div", {className: "row"}, 
                        React.createElement("div", {className: "col-md-12 text-center"}, 
                            React.createElement("div", {className: "block wow fadeInUp", "data-wow-delay": ".3s"}, 
                                React.createElement("section", {className: "cd-intro"}, 
                                    React.createElement("div", {className: "login-box"}, 

                                        React.createElement("div", {className: "login-logo"}, 
                                            React.createElement("a", {href: "#"}, React.createElement("b", null, "B"), "log")
                                        ), 

                                        React.createElement("div", {className: "register-box-body", style: StyleForm}, 
                                            React.createElement("p", {className: "login-box-msg"}, "Registrar novo usuário"), 
                                            React.createElement(FormRegister, null)
                                        )

                                    )
                                )
                            )
                        )
                    )
                )
            )
        )
    }
});

var FormRegister = React.createClass({displayName: "FormRegister",

    handleForm : function (e) {

        e.preventDefault();

        var nome = this.refs.nome.value;
        var email = this.refs.email.value;
        var password = this.refs.password.value;
        var password_confirm = this.refs.password_confirm.value;

        if (!nome) {
            $("#nome").focus();
            $("#nome").addClass("is-danger");
            alertify.error("Deve Informar o seu Nome");
            return false;
        }

        $("#nome").removeClass("is-danger");

        if (!email) {
            $("#email").focus();
            $("#email").addClass("is-danger");
            alertify.error("Deve Informar o E-mail");
            return false;
        }

        $("#email").removeClass("is-danger");

        if (!password) {
            $("#password").focus();
            $("#password").addClass("is-danger");
            alertify.error("Deve Informar uma senha");
            return false;
        }

        $("#password").removeClass("is-danger");

        if (password != password_confirm) {
            $("#password").addClass("is-danger");
            $("#password_confirm").addClass("is-danger");
            alertify.error("As Senhas n&atilde;o s&atilde;o iguais.");
            return false;
        }

        $("#password").removeClass("is-danger");
        $("#password_confirm").removeClass("is-danger");

        $("#btnSubmit").addClass("is-loading");
        
        block_screen();

        $.ajax({
            type: 'POST',
            url : "/register/save",
            data : $("#form").serialize(),
            cache: false,
            success: function (data) {

                $.ajax({
                    type: 'POST',
                    url : "/admin/login_check",
                    data : {
                        _username : email,
                        _password : password
                    },
                    cache: false,
                    success: function (data) {
                        window.location.href = '/user/';
                        return false;
                    },
                    error: function () {
                        unblock_screen();
                        $("#btnSubmit").removeClass("is-loading");
                        alertify.error("opss, algo deu errado...");
                        return false;
                    }
                });

            },
            error: function () {
                unblock_screen();
                $("#btnSubmit").removeClass("is-loading");
                alertify.error("opss, algo deu errado...");
            }
        })
    },

    render: function () {

        return (

            React.createElement("form", {onSubmit: this.handleForm, method: "post", id: "form"}, 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {className: "input", type: "text", name: "nome", placeholder: "Nome Completo", id: "nome", ref: "nome"}), 
                    React.createElement("span", {className: "glyphicon glyphicon-user form-control-feedback"})
                ), 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {className: "input", type: "text", name: "email", placeholder: "E-mail", id: "email", ref: "email"}), 
                    React.createElement("span", {className: "glyphicon glyphicon-envelope form-control-feedback"})
                ), 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {className: "input", type: "password", name: "password", placeholder: "Senha", id: "password", 
                           ref: "password"}), 
                    React.createElement("span", {className: "glyphicon glyphicon-log-in form-control-feedback"})
                ), 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {className: "input", type: "password", name: "password_confirm", placeholder: "Confirme a senha", 
                           id: "password_confirm", ref: "password_confirm"}), 
                    React.createElement("span", {className: "glyphicon glyphicon-log-in form-control-feedback"})
                ), 
                React.createElement("div", {className: "row"}, 
                    React.createElement("div", {className: "col-xs-6"}, 
                        React.createElement("a", {href: "#", className: "button is-light is-fullwidth"}, "Entrar")
                    ), 
                    React.createElement("div", {className: "col-xs-6"}, 
                        React.createElement("button", {type: "submit", id: "btnSubmit", className: "button is-success is-fullwidth"}, "Salvar")
                    )
                )
            )
        )
    }

});

var background = $("#register").data("background");
var dirImg = $("#register").data("dir-img");

ReactDOM.render(
    React.createElement("div", null, 
        React.createElement(Register, null)
    ),
    document.getElementById("register")
);

