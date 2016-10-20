/**
 * Created by cesar on 20/10/16.
 */

(function($){
    'use strict';

    var EditUserForm = React.createClass({displayName: "EditUserForm",
        getInitialState: function() {
            return {showForm: false};
        },

        componentDidMount : function () {
            get(this.props.source);
        },

        toggleEditForm: function() {
            this.setState({showForm: !this.state.showForm});
        },
        handleSubmit: function(e){
            e.preventDefault();
            var name = React.findDOMNode(this.refs.name).value.trim();
            var email = React.findDOMNode(this.refs.email).value.trim();
            if (!name || !email) {
                return;
            }

            $.ajax({
                type: 'PUT',
                url: this.props.source + this.props.user.id,
                data: {
                    name: name,
                    email: email
                }
            })
                .done(function(res){
                    this.toggleEditForm();
                    this.props.reloadUser();
                }.bind(this))
                .fail(function(res){
                    var errors = $.parseJSON(res.responseText).data;
                    console.log(errors);
                });

            React.findDOMNode(this.refs.name).value = '';
            React.findDOMNode(this.refs.email).value = '';
            return;
        },
        render: function() {
            return (
                React.createElement("span", null, 
		 this.state.showForm ?
            React.createElement("form", {onSubmit: this.handleSubmit}, 
                React.createElement("input", {type: "text", placeholder: "name...", ref: "name", defaultValue: this.props.user.name}), 
                React.createElement("input", {type: "text", placeholder: "email...", ref: "email", defaultValue: this.props.user.email}), 
                React.createElement("input", {type: "submit", value: "update"}), 
                React.createElement("a", {href: "#", onClick: this.toggleEditForm}, "?????")
            )
            :
            React.createElement("span", null, 
		this.props.user.name, " - ", this.props.user.email, 
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

