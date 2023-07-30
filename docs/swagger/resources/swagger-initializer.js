window.onload = function () {

    window.ui = SwaggerUIBundle({
        url: "swagger/swagger.yaml",
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        presets_config: {
            SwaggerUIStandalonePreset: {
                TopbarPlugin: false
            }
        },
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout"
    });

};
