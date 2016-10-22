/**
 * Created by cesar on 22/10/16.
 */

$(function () {

    var Modal = React.createClass({
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
                <div id="scheduleentry-modal" className="modal fade" tabIndex="-1">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header">
                                <button type="button" className="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                                <h4 className="modal-title">{this.props.title}</h4>
                            </div>
                            <div className="modal-body">
                                {this.props.children}
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="button is-danger is-outlined is-pulled-left" data-dismiss="modal">Cancelar</button>
                                <button type="submit" className="button is-success">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>

            )
        }
    });

});