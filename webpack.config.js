
module.exports = {
    entry: [
        "./src/js/login",
        "./src/js/register",
        "./src/js/forgotten_password",
        "./src/js/password",
        "./src/js/template",
        "./src/js/user",
        "./src/js/search",
        "./src/js/anexos",
        "./src/js/view",
        "./src/js/categorias",
        "./src/js/colecoes",
        "./src/js/musicas",
        "./src/js/favoritos",
        "./src/js/categoria_adicionar",
        "./src/js/categoria_editar",
        "./src/js/musica_adicionar",
        "./src/js/musica_adicionar_2",
        "./src/js/musicas_adicionadas",
        "./src/js/musica_adicionar_mesma_categoria",
    ],
    output: {
        filename: "web/assets/build/bundle.js"
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel',
                query: {
                    presets: ['react']
                }
            }
        ]
    }
};