/**
 * Created by cesar on 03/11/16.
 */


/**
 * Created by cesar on 03/11/16.
 */

var React = require("react");

var FormRegister = React.createClass({

    render: function () {

        return (
            
            <form>
                <div className="form-group has-feedback">
                    <input class="form-control" type="text" name="nome" placeholder="nome" id="nome" ref="nome"/>
                    <span className="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div className="form-group has-feedback">
                    <input class="form-control" type="text" name="nickname" placeholder="nickname" id="nickname"
                           ref="nickname"/>
                    <span className="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div className="form-group has-feedback">
                    <input class="form-control" type="text" name="email" placeholder="email" id="email" ref="email"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div className="form-group has-feedback">
                    <input class="form-control" type="text" name="password" placeholder="password" id="password"
                           ref="password"/>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div className="form-group has-feedback">
                    <input class="form-control" type="text" name="password_confirm" placeholder="password_confirm"
                           id="password_confirm" ref="password_confirm"/>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
            </form>
                
        )

    }

});

module.exports = FormRegister;
