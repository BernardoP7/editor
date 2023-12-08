<?php

namespace App\Http\Controllers;
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../Services/ajax.php';
require_once __DIR__ . '/../../Services/trackmanager.php';
require_once __DIR__.'/../../Services/functions.php';

use App\Services\Common\HTTPStatus;
use Illuminate\Http\Request;
use App\Services\Common\URL;
use App\Services\Views\DocEditorView;
use App\Services\Views\IndexView;
use App\Services\Views\IndexStoredListView;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\Configuration\ConfigurationManager;
use function App\Services\serverPath;
use function App\Services\track;
use function App\Services\download;
use function App\Services\upload;
use function App\Services\saveas;
use function App\Services\restore;
use function App\Services\renamefile;
use function App\Services\reference;
use function App\Services\historyDownload;
use function App\Services\files;

use function App\Services\delete;
use function App\Services\csv;
use function App\Services\convert;
use function App\Services\assets;
use function App\Services\getClientIp;

class Controller extends BaseController
{
    function index(){
        
       $url = new URL($_SERVER['REQUEST_URI']);
        $path = $url->path();
        header('Content-Type: text/html; charset=utf-8');
        $view = new IndexView($_REQUEST);
        
        
        $view->render();

    }
    function editor(Request $request){
        header('Content-Type: text/html; charset=utf-8');
        $view = new DocEditorView($request);
        $view->render();
    }
    function track(){
        $response = track();
        $response['status'] = 'success';
        echo json_encode($response);
        return;

    }
    function download(){
        $response = download();
        $response['status'] = 'success';
        echo json_encode($response);
        return;

    }
    function upload(){
        $response = upload();
        $response['status'] = isset($response['error']) ? 'error' : 'success';
        echo json_encode($response);
        return;
    }

    function saveas(){
        $response = saveas();
        $response['status'] = 'success';
        echo json_encode($response);
        return;
    }
    
    function restore(){
        $response = restore();
        echo json_encode($response);
        return;
    }

    function rename(){
        $response = renamefile();
        $content = json_encode($response);
        echo $content;
        return;
    }

    function reference(){
        $response = reference();
        $response['status'] = 'success';
        echo json_encode($response);
        return;
    }

    function history(){
        $response = historyDownload();
        $response['status'] = 'success';
        echo json_encode($response);
        return;
    }
    function files(){
        $response = files();
        echo json_encode($response);
        return;
    }
    function delete(){
        $response = delete();
        $response['status'] = isset($response['error']) ? 'error' : 'success';
        echo json_encode($response);
        return;
    }

    function csv(){
        $response = csv();
        $response['status'] = 'success';
        echo json_encode($response);
        return;
    }

    function convert(){
        $response = convert();
        $response['status'] = 'success';
        echo json_encode($response);
        return;
    }

    function assets(){
        $response = assets();
        $response['status'] = 'success';
        echo json_encode($response);
        return;
    }
}
