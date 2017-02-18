/**
 * Created by cesar on 01/02/17.
 */

const StyleForm = {
    backgroundColor: "transparent"
};

class BASE extends React.Component {
    render() {
        return (
            <section id="hero-area">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12 text-center">
                            <div className="block wow fadeInUp" data-wow-delay=".3s">
                                <section className="cd-intro">
                                    <div className="login-box">
                                        <div className="login-logo text-black">
                                            <a href="/"><b>{this.props.app}</b></a>
                                        </div>

                                        <div className="login-box-body" style={StyleForm}>
                                            <p className="login-box-msg">Entre para iniciar a sess&atilde;o</p>
                                            {this.props.children}
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
}
;


const Form = React.createClass({

    handleSubmit: function (e) {

        var email = this.refs._username.value;
        var password = this.refs._password.value;

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
        $("#btnSubmit").addClass("is-loading");

        return true;
    },

    render: function () {

        let error = '';

        if (this.props.error) {
            error = (
                <div className="notification is-danger">
                    <button className="delete"></button>
                    {this.props.error}
                </div>
            );
        }

        return (
            <form method="post" action={this.props.post} onSubmit={this.handleSubmit}>
                {error}
                <div className="form-group has-feedback">
                    <input type="email" name="_username" autoFocus="autoFocus"
                           className="form-control" placeholder="E-mail" ref="_username" required="required" defaultValue={this.props.lastUserName}/>
                    <span className="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div className="form-group has-feedback">
                    <input type="password" name="_password" className="form-control"
                           placeholder="Password" required="required" title="Informe a Senha" ref="_password"/>
                    <span className="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div className="row">
                    <div className="col-xs-6">
                        <a href="register" className="button is-primary is-outlined is-fullwidth">Registrar</a>
                    </div>
                    <div className="col-xs-6">
                        <button type="submit" className="button is-success is-outlined is-fullwidth">Entrar</button>
                    </div>
                </div>
            </form>
        )
    }
});

const Render = React.createClass({

    render: function () {
        return (
            <BASE app={this.props.app}>
                <Form post={this.props.post} error={this.props.error} password={this.props.password} lastUserName={this.props.lastUserName}/>
            </BASE>
        )
    }
});

if (document.getElementById('login')) {

    const app = $("#login").data("app");
    const post = $("#login").data("post");
    const error = $("#login").data("error");
    const password = $("#login").data("password");
    const lastUserName = $("#login").data("last-user-name");

    $(document).on('click', '.notification > button.delete', function() {
        $(this).parent().addClass('is-hidden');
        return false;
    });

    ReactDOM.render(
        <Render app={app} post={post} error={error} password={password} lastUserName={lastUserName}/>, document.getElementById('login')
    );
}