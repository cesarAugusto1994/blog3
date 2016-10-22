/**
 * Created by cesar on 22/10/16.
 */

$(function () {

    const modal = React.createClass({displayName: "modal",
        componentDidMount: function() {
            $(this.getDOMNode)
                .modal({backdrop: "static", keyboard: true, show: false});
        },

        componentWillUnmount: function() {
            $(this.getDOMNode)
                .off("hidden", this.handleHidden);
        },

        open: function() {
            $(this.getDOMNode).modal("show");
        },

        close: function() {
            $(this.getDOMNode).modal("hide");
        },

        render: function() {
            return (
                React.createElement("div", {id: "scheduleentry-modal", className: "modal fade", tabIndex: "-1"}, 
                    React.createElement("div", {className: "modal-dialog"}, 
                        React.createElement("div", {className: "modal-content"}, 
                            React.createElement("div", {className: "modal-header"}, 
                                React.createElement("button", {type: "button", className: "close", "data-dismiss": "modal"}, 
                                    React.createElement("span", null, "×")
                                ), 
                                React.createElement("h4", {className: "modal-title"}, this.props.title)
                            ), 
                            React.createElement("div", {className: "modal-body"}, 
                                this.props.children
                            ), 
                            React.createElement("div", {className: "modal-footer"}, 
                                React.createElement("button", {type: "button", className: "button is-danger is-outlined is-pulled-left", "data-dismiss": "modal"}, "Cancelar"), 
                                React.createElement("button", {type: "submit", className: "button is-success"}, "Salvar")
                            )
                        )
                    )
                )

            )
        }
    });

});