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
        return {categorias: [], colecao : []};
    },

    load: function () {
        $.get('/user/categorias', function (result) {
            this.setState({categorias: result});
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
                        <select id="categoria" name="categoria" ref="categoria" defaultValue={this.props.categoria} required>
                            {this.state.categorias.map(function (colecao) {
                                return (
                                    <optgroup key={colecao.nome} label={colecao.nome}>
                                        {colecao.categorias.map(function (categoria) {
                                            return (
                                                <option key={categoria.id} value={categoria.id}>{categoria.nome}</option>
                                            )
                                        })}
                                    </optgroup>
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

if (document.getElementById("anexos-adicionar")) {
    ReactDOM.render(<Render/>, document.getElementById('anexos-adicionar'));
}