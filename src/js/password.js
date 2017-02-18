/**
 * Created by cesar on 03/11/16.
 */

var style = {
    padding: "0",
    backgroundImage: 'url(' + $("#password").data("dir-img") + $("#password").data("background") + ')'
};

const StyleForm = {
    backgroundColor: "transparent"
};

var Forgot = React.createClass({

    render: function () {

        return (
            <section id="hero-area">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12 text-center">
                            <div className="block wow fadeInUp">
                                <section className="cd-intro">
                                    <div className="login-box">

                                        <div className="login-logo">
                                            <a href="/"><b>{this.props.app}</b></a>
                                        </div>

                                        <div className="register-box-body" style={StyleForm}>
                                            <p className="login-box-msg">Digite o seu E-mail</p>
                                            <FormRegister />
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

        const email = this.refs.email.value;

        if (!email) {
            $("#email").focus();
            $("#email").addClass("is-danger");
            alertify.error("Deve Informar o E-mail");
            return false;
        }

        $("#email").removeClass("is-danger");

        $("#btnSubmit").addClass("is-loading");
        
        block_screen();

        $.ajax({
            type: 'POST',
            url : "/forgot-password",
            data : $("#form").serialize(),
            cache: false,
            success: function (data) {
                alertify.success(data.mensagem);
            },
            error: function (data) {
                unblock_screen();
                $("#btnSubmit").removeClass("is-loading");
                alertify.error(data.mensagem);
            }
        })
    },

    render: function () {

        return (

            <form onSubmit={this.handleForm} method="post" id="form">
                <div className="form-group has-feedback">
                    <input className="input" autoFocus="autoFocus" autoComplete="off" type="email" name="email" placeholder="E-mail" id="email" ref="email"/>
                    <span className="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div className="row">
                    <div className="col-xs-6">
                        <a href="login" className="button is-light is-fullwidth">Voltar ao In&iacute;cio</a>
                    </div>
                    <div className="col-xs-6">
                        <button type="submit" id="btnSubmit" className="button is-success is-fullwidth">Enviar</button>
                    </div>
                </div>
            </form>
        )
    }

});

const background = $("#password").data("background");
const app = $("#password").data("app");

if (document.getElementById("password")) {
    ReactDOM.render(
        <Forgot app={app}/>,
        document.getElementById("password")
    );
}

