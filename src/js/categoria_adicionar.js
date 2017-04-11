/**
 * Created by cesar on 25/01/17.
 */


class Container extends React.Component {

    render() {
        return (
            <article>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                            {this.props.children}
                        </div>
                    </div>
                </div>
            </article>
        );
    }

};

const Render = React.createClass({

    getInitialState: function () {
        return {data: [], colecao : []};
    },

    load: function () {
        $.get('/api/colecoes', function (result) {
            this.setState({data: result});
        }.bind(this));
    },

    componentDidMount: function () {
        this.load();
    },

    redirect : function () {
        return window.location.href = '/user/collection/' + this.props.colecaoId + '-' + this.props.colecaoNome;
    },

    handleSubmit : function (e) {

        e.preventDefault();

        let nome = this.refs.nome.value.trim();
        let colecao = this.refs.colecao.value.trim();

        if (!nome || !colecao) {
            alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
        }

        const _this = this;

        $.ajax({
            type: "POST",
            url: "/api/categoria/adicionar",
            data : {
                nome : nome,
                colecao : colecao
            },
            cache: false,
            success: function (data) {
                alertify.success(data.mensagem);
                unblock_screen();
                _this.redirect();
            },
            error: function (data) {
                unblock_screen();
                alertify.error(data.mensagem);
            }
        });
    },

    render : function () {
        return (
            <Container>
                <form onSubmit={this.handleSubmit}>
                    <label className="label text-black">Nome</label>
                    <p className="control">
                        <input className="input" type="text" placeholder="Nome" autoFocus="autoFocus" ref="nome" name="nome" id="nome" required />
                    </p>

                    <label className="label text-black">Cole&ccedil;&atilde;o</label>
                    <div className="select is-fullwidth">
                        <select ref="colecao" name="colecao" id="colecao" defaultValue={this.props.colecaoId}>
                            { this.state.data.map(function (colecao) {
                                return (
                                    <option key={colecao.id} value={colecao.id}>{colecao.nome}</option>
                                )
                            })}
                        </select>
                    </div>
                    <br/>
                    <br/>
                    <p className="control">
                        <button className="button is-fullwidth is-danger">Salvar</button>
                    </p>
                </form>
            </Container>
        )
    }
});

if (document.getElementById("categoria-adicionar")) {

    const colecaoId = $("#categoria-adicionar").data("colecao-id");
    const colecaoNome = $("#categoria-adicionar").data("colecao-nome");

    ReactDOM.render(<Render
        colecaoId={colecaoId}
        colecaoNome={colecaoNome}
    />, document.getElementById('categoria-adicionar'));
}