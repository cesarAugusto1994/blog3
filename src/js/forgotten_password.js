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

var Register = React.createClass({

    render: function () {

        return (
            <section id="hero-area">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12 text-center">
                            <div className="block wow fadeInUp" data-wow-delay=".3s">
                                <section className="cd-intro">
                                    <div className="login-box">

                                        <div className="login-logo">
                                            <a href="/"><b>{this.props.app}</b></a>
                                        </div>

                                        <div className="register-box-body" style={StyleForm}>
                                            <p className="login-box-msg">Redefinir Senha</p>
                                            <FormRegister email={this.props.email}/>
                                        </div>

                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        )
    }
});

var FormRegister = React.createClass({

    handleForm : function (e) {

        e.preventDefault();

        var email = this.refs.email.value;
        var password = this.refs.password.value;
        var password_confirm = this.refs.password_confirm.value;


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
            url : "/forgotten-password/save",
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

    handlePassLength : function () {

        if (0 < this.refs.password.value.length && 6 > this.refs.password.value.length) {
            $("#password").addClass("is-danger");
            $("#div-password > .help").text("Sua Senha deve conter mais de 6 caracteres.");
        } else {
            $("#password").removeClass("is-danger");
            $("#password").addClass("is-success");
            $("#div-password > .help").text("");
        }

    },

    handleConfirmPass : function () {

        if (this.refs.password_confirm.value != this.refs.password.value) {
            $("#password_confirm").addClass("is-danger");
        } else {
            $("#password_confirm").removeClass("is-danger");
            $("#password_confirm").addClass("is-success");
        }

    },

    render: function () {

        return (

            <form onSubmit={this.handleForm} method="post" id="form">
                <div className="form-group has-feedback">
                    <input className="input is-large" type="text" defaultValue={this.props.email} readOnly name="email" placeholder="E-mail" id="email" ref="email"/>
                    <span className="glyphicon glyphicon-envelope form-control-feedback is-large"></span>
                </div>
                <div className="form-group has-feedback" id="div-password">
                    <input className="input is-large" type="password" autoFocus="autoFocus" name="password" onChange={this.handlePassLength} placeholder="Senha" id="password"
                           ref="password"/>
                    <span className="help is-danger"></span>
                    <span className="glyphicon glyphicon-log-in form-control-feedback is-large"></span>
                </div>
                <div className="form-group has-feedback" id="div-password-confirm">
                    <input className="input is-large" type="password" name="password_confirm" onChange={this.handleConfirmPass} placeholder="Confirme a senha"
                           id="password_confirm" ref="password_confirm"/>
                    <span className="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div className="row">
                    <div className="col-xs-12">
                        <button type="submit" id="btnSubmit" className="button is-success  is-large is-outlined is-fullwidth">Salvar</button>
                    </div>
                </div>
            </form>
        )
    }

});

const background = $("#forgotten").data("background");
const app = $("#forgotten").data("app");
const email = $("#forgotten").data("email");

if (document.getElementById("forgotten")) {
    ReactDOM.render(
        <div>
            <Register app={app} email={email}/>
        </div>,
        document.getElementById("forgotten")
    );
}

