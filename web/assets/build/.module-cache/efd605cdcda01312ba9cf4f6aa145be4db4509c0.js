/**
 * Created by cesar on 03/11/16.
 */


/**
 * Created by cesar on 03/11/16.
 */

var React = require("react");

var FormRegister = React.createClass({displayName: "FormRegister",

    render: function () {

        return (
            
            React.createElement("form", null, 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {class: "form-control", type: "text", name: "nome", placeholder: "nome", id: "nome", ref: "nome"}), 
                    React.createElement("span", {className: "glyphicon glyphicon-user form-control-feedback"})
                ), 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {class: "form-control", type: "text", name: "nickname", placeholder: "nickname", id: "nickname", 
                           ref: "nickname"}), 
                    React.createElement("span", {className: "glyphicon glyphicon-user form-control-feedback"})
                ), 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {class: "form-control", type: "text", name: "email", placeholder: "email", id: "email", ref: "email"}), 
                    React.createElement("span", {class: "glyphicon glyphicon-envelope form-control-feedback"})
                ), 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {class: "form-control", type: "text", name: "password", placeholder: "password", id: "password", 
                           ref: "password"}), 
                    React.createElement("span", {class: "glyphicon glyphicon-log-in form-control-feedback"})
                ), 
                React.createElement("div", {className: "form-group has-feedback"}, 
                    React.createElement("input", {class: "form-control", type: "text", name: "password_confirm", placeholder: "password_confirm", 
                           id: "password_confirm", ref: "password_confirm"}), 
                    React.createElement("span", {class: "glyphicon glyphicon-log-in form-control-feedback"})
                )
            )
                
        )

    }

});

module.exports = FormRegister;
