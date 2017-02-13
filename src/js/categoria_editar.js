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
        return window.location.href = '/user/collection/' + this.props.colecaoId + '-' + this.props.colecaoNome + '/categories';
    },

    handleSubmit : function (e) {

        e.preventDefault();

        let id = this.refs.id.value.trim();
        let nome = this.refs.nome.value.trim();
        let colecao = this.refs.colecao.value.trim();

        if (!nome || !colecao) {
            alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
        }

        const _this = this;

        $.ajax({
            type: "POST",
            url: "/api/category/edit",
            data : {
                id : id,
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
                    <input type="hidden" name="id" ref="id" id="id" value={this.props.categoriaId}/>
                    <label className="label text-black">Nome</label>
                    <p className="control">
                        <input className="input" type="text" placeholder="Nome" autoFocus="autoFocus" ref="nome"
                               name="nome" id="nome" required defaultValue={this.props.categoriaNome}/>
                    </p>

                    <label className="label text-black">Cole&ccedil;&atilde;o</label>
                    <p className="control">
                        <div className="select is-fullwidth">
                            <select ref="colecao" name="colecao" id="colecao" defaultValue={this.props.colecaoId}>
                                { this.state.data.map(function (colecao) {
                                    return (
                                        <option key={colecao.id} value={colecao.id}>{colecao.nome}</option>
                                    )
                                })}
                            </select>
                        </div>
                    </p>
                    <p className="control">
                        <button className="button is-fullwidth is-primary">Salvar</button>
                    </p>
                </form>
            </Container>
        )
    }
});

if (document.getElementById("categoria-editar")) {


    const categoriaId = $("#categoria-editar").data("categoria-id");
    const categoriaNome = $("#categoria-editar").data("categoria-nome");
    
    const colecaoId = $("#categoria-editar").data("colecao-id");
    const colecaoNome = $("#categoria-editar").data("colecao-nome");

    ReactDOM.render(<Render
        categoriaId={categoriaId}
        categoriaNome={categoriaNome}
        colecaoId={colecaoId}
        colecaoNome={colecaoNome}
    />, document.getElementById('categoria-editar'));
}