/**
 * Created by cesar on 20/10/16.
 */

(function($){
    'use strict';



    var EditUserForm = React.createClass({displayName: "EditUserForm",
        getInitialState: function() {
            return {showForm: true};
        },

        render: function() {
            return (
            React.createElement("span", null, 
             this.state.showForm ?
            React.createElement("form", {class: "form-horizontal wow fadeInUp animated slide", "data-wow-delay": ".6s", onSubmit: this.handleSubmit}, 
            React.createElement("input", {type: "hidden", name: "id", value: "", ref: "id"}), 
            React.createElement("p", {class: "control"}, "Nome Completo", 
                React.createElement("input", {type: "text", placeholder: "Nome", class: "input", name: "nome", required: true, ref: "name"})
            ), 
            React.createElement("p", {class: "control"}, "Nickname", 
                React.createElement("input", {class: "input", type: "text", placeholder: "Nickname", name: "nickname", required: true, ref: "nickname"})
            ), 
            React.createElement("p", {class: "control"}, "E-mail", 
                React.createElement("input", {class: "input", type: "text", placeholder: "email", name: "email", required: true, ref: "email"})
            ), 
            React.createElement("p", {class: "control"}, 
                React.createElement(Button, {"is-primary": true, "is-loading": true}, "Salvar")
            )
            )
            :
            React.createElement("span", null, 
            React.createElement("a", {href: "#", onClick: this.toggleEditForm}, "??")
            )
        
            )
            );
        }
    });

    ReactDOM.render(
        React.createElement("h1", null, "Hello, world!"),
        document.getElementById('example')
    );

    var source = document.getElementById('user').getAttribute('data-source');

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(EditUserForm, {source: source})
        ),
        document.getElementById('user')
    );
    
})(jQuery);

