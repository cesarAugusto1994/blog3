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

}
;

const Render = React.createClass({

    getInitialState: function () {
        return {data: [], categorias: [], categoria: [], tons: []};
    },

    load: function () {
        $.get('/user/categorias', function (result) {
            this.setState({categorias: result});
        }.bind(this));

        $.get('/user/tonalidades', function (result) {
            this.setState({tons: result})
        }.bind(this));
    },

    componentDidMount: function () {
        this.load();
    },

    handleSubmit: function (e) {

        e.preventDefault();

        let nome1 = this.refs.nome1.value.trim();
        let numero1 = this.refs.numero1.value.trim();
        let tonalidade1 = this.refs.tonalidade1.value.trim();
        let categoria1 = this.refs.categoria1.value.trim();

        let nome2 = this.refs.nome2.value.trim();
        let numero2 = this.refs.numero2.value.trim();
        let tonalidade2 = this.refs.tonalidade2.value.trim();
        let categoria2 = this.refs.categoria2.value.trim();

        let nome3 = this.refs.nome3.value.trim();
        let numero3 = this.refs.numero3.value.trim();
        let tonalidade3 = this.refs.tonalidade3.value.trim();
        let categoria3 = this.refs.categoria3.value.trim();

        let nome4 = this.refs.nome4.value.trim();
        let numero4 = this.refs.numero4.value.trim();
        let tonalidade4 = this.refs.tonalidade4.value.trim();
        let categoria4 = this.refs.categoria4.value.trim();

        let nome5 = this.refs.nome5.value.trim();
        let numero5 = this.refs.numero5.value.trim();
        let tonalidade5 = this.refs.tonalidade5.value.trim();
        let categoria5 = this.refs.categoria5.value.trim();

        let nome6 = this.refs.nome6.value.trim();
        let numero6 = this.refs.numero6.value.trim();
        let tonalidade6 = this.refs.tonalidade6.value.trim();
        let categoria6 = this.refs.categoria6.value.trim();

        let nome7 = this.refs.nome7.value.trim();
        let numero7 = this.refs.numero7.value.trim();
        let tonalidade7 = this.refs.tonalidade7.value.trim();
        let categoria7 = this.refs.categoria7.value.trim();

        let nome8 = this.refs.nome8.value.trim();
        let numero8 = this.refs.numero8.value.trim();
        let tonalidade8 = this.refs.tonalidade8.value.trim();
        let categoria8 = this.refs.categoria8.value.trim();

        let nome9 = this.refs.nome9.value.trim();
        let numero9 = this.refs.numero9.value.trim();
        let tonalidade9 = this.refs.tonalidade9.value.trim();
        let categoria9 = this.refs.categoria9.value.trim();

        let nome10 = this.refs.nome10.value.trim();
        let numero10 = this.refs.numero10.value.trim();
        let tonalidade10 = this.refs.tonalidade10.value.trim();
        let categoria10 = this.refs.categoria10.value.trim();

        /*
        if (!nome || !categoria) {
            alertify.error("O Nome da Musica e a Categoria devem ser informadas.");
        }
        */

        let categoriaID = this.refs.categoria1.value;
        let categoriaNome = "category";
        const PRAISES = '/user/category/' + categoriaID + '-' + categoriaNome + '/praises';

        $.ajax({
            type: "POST",
            url: "/api/musica/adicionar/varios",
            data: {
                itens: [
                    {nome : nome1, numero : numero1, tonalidade : tonalidade1, categoria : categoria1},
                    {nome : nome2, numero : numero2, tonalidade : tonalidade2, categoria : categoria2},
                    {nome : nome3, numero : numero3, tonalidade : tonalidade3, categoria : categoria3},
                    {nome : nome4, numero : numero4, tonalidade : tonalidade4, categoria : categoria4},
                    {nome : nome5, numero : numero5, tonalidade : tonalidade5, categoria : categoria5},
                    {nome : nome6, numero : numero6, tonalidade : tonalidade6, categoria : categoria6},
                    {nome : nome7, numero : numero7, tonalidade : tonalidade7, categoria : categoria7},
                    {nome : nome8, numero : numero8, tonalidade : tonalidade8, categoria : categoria8},
                    {nome : nome9, numero : numero9, tonalidade : tonalidade9, categoria : categoria9},
                    {nome : nome10, numero : numero10, tonalidade : tonalidade10, categoria : categoria10}
                ],
            },
            cache: false,
            success: function (data) {
                alertify.success(data.message);
                if (data.classe == 'sucess') {
                    window.location.href = PRAISES;
                }
                unblock_screen();
            },
            error: function (data) {
                alertify.error(data.message);
                unblock_screen();
            }
        });
    },

    render: function () {

        return (
            <Container>
                <form className="form-horizontal" method="POST" onSubmit={this.handleSubmit}>

                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome1" name="nome1" id="nome1" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero1" name="numero1" id="numero1"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade1" ref="tonalidade1" id="tonalidade1">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria1" name="categoria1" ref="categoria1" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>



                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome2" name="nome2" id="nome2" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero2" name="numero2" id="numero2"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade2" ref="tonalidade2" id="tonalidade2">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria2" name="categoria2" ref="categoria2" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>


                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome3" name="nome3" id="nome3" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero3" name="numero3" id="numero3"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade3" ref="tonalidade3" id="tonalidade3">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria3" name="categoria3" ref="categoria3" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>



                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome4" name="nome4" id="nome4" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero4" name="numero4" id="numero4"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade4" ref="tonalidade4" id="tonalidade4">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria4" name="categoria4" ref="categoria4" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>


                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome5" name="nome5" id="nome5" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero5" name="numero5" id="numero5"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade5" ref="tonalidade5" id="tonalidade5">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria5" name="categoria5" ref="categoria5" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>



                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome6" name="nome6" id="nome6" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero6" name="numero6" id="numero6"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade6" ref="tonalidade6" id="tonalidade6">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria6" name="categoria6" ref="categoria6" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>


                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome7" name="nome7" id="nome7" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero7" name="numero7" id="numero7"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade7" ref="tonalidade7" id="tonalidade7">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria7" name="categoria7" ref="categoria7" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>


                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome8" name="nome8" id="nome8" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero8" name="numero8" id="numero8"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade8" ref="tonalidade8" id="tonalidade8">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria8" name="categoria8" ref="categoria8" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>


                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome9" name="nome9" id="nome9" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero9" name="numero9" id="numero9"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade9" ref="tonalidade9" id="tonalidade9">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria9" name="categoria9" ref="categoria9" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>


                    <div className="control is-grouped">
                        <p className="control is-expanded">
                            <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome10" name="nome10" id="nome10" />
                        </p>
                        <p className="control is-expanded">
                            <input className="input" type="text" size="20" placeholder="N&uacute;mero" ref="numero10" name="numero10" id="numero10"/>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select name="tonalidade10" ref="tonalidade10" id="tonalidade10">
                                    {this.state.tons.map(function (tom) {
                                        return (
                                            <option key={tom} defaultValue={tom}>{tom}</option>
                                        )
                                    })}
                                </select>
                            </div>
                        </p>
                        <p className="control is-expanded">
                            <div className="select is-fullwidth">
                                <select id="categoria10" name="categoria10" ref="categoria10" defaultValue={this.props.categoria} >
                                    {this.state.categorias.map(function (colecao) {
                                        return (
                                            <optgroup label={colecao.nome}>
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
                        </p>
                    </div>


                    <p className="control">
                        <button className="button is-danger is-fullwidth" type="submit">Salvar</button>
                    </p>
                </form>
            </Container>
        )
    }
});

if (document.getElementById("musica-adicionar-2")) {

    const categoria = $("#musica-adicionar").data("categoria");

    ReactDOM.render(<Render categoria={categoria}/>, document.getElementById('musica-adicionar-2'));
}