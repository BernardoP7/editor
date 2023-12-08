<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Editor</title>
</head>
<body>

<div id="editor"></div>

<script src="https://onlyoffice.com/editors/web-apps/apps/api/documents/api.js"></script>
<script>
    function openDocEditor() {
        // Substitua 'your_document_url' pela URL do documento que deseja editar.
        var documentUrl = 'your_document_url';

        // Configurações para a criação do editor OnlyOffice.
        var config = {
            document: {
                fileType: 'docx',
                key: 'your_document_key',
                title: 'Nome do Documento',
                url: documentUrl,
            },
            editorConfig: {
                callbackSave: function (url) {
                    console.log('Documento salvo em: ' + url);
                },
            },
        };

        // Criação do editor OnlyOffice.
        var docEditor = new DocsAPI.DocEditor('editor', config);
        docEditor.init();

        // Adiciona um botão para fechar o editor (opcional).
        var closeButton = document.createElement('button');
        closeButton.innerHTML = 'Fechar Editor';
        closeButton.onclick = function () {
            docEditor.destroyEditor();
        };
        document.body.appendChild(closeButton);
    }
</script>

<button onclick="openDocEditor()">Abrir Editor de Documentos</button>

</body>
</html>