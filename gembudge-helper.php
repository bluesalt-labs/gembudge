<?php
class GembudgeHelper {
    const BUFFER_SIZE = 10;
    const DATA_FILENAME = "/data/database.json";

    private $filename;
    private $fileHandle;
    private $newData;
    private $requestType;
    private $fileBuffer;
    private $output;

    public function __construct() {
        // todo: security validation?

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->output = [];
            if( !isset($_POST['type']) ) { $this->returnError("Must include request type!"); }

            // Get the request type
            $this->requestType = $_POST['type'];

            $this->openOrCreateFile();

            switch( strtolower($this->requestType) ) {
                case "add":
                    if( !isset($_POST['data']) ) { $this->returnError("Must include data with this request type!"); }
                    $this->newData = json_decode($_POST['data']);
                    $this->addItem( (isset($_POST['index']) ? $_POST['index'] : null) );
                    break;
                case "edit":
                    if( !isset($_POST['data']) ) { $this->returnError("Must include data with this request type!"); }
                    if( !isset($_POST['index']) ) { $this->returnError("Must include index with this request type!"); }
                    $this->newData = json_decode($_POST['data']);
                    $this->editItem($_POST['index']);
                    break;
                case "remove":
                    if( !isset($_POST['index']) ) { $this->returnError("Must include index with this request type!"); }
                    $this->removeItem($_POST['index']);
                    break;
                default:
                    $this->returnError("Invalid request type");
            }

        }
        else if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->openOrCreateFile(true);

            $count = self::BUFFER_SIZE;

            if( isset($_GET['count']) && (intval($_GET['count']) > 0) ) {
                $count = intval($_GET['count']);
            }

            $this->getFileData($count);
        }
    }

    public function addItem($afterID = null) {
        // todo
    }

    public function editItem($atID) {
        // todo
    }

    public function removeItem($atID) {
        // todo
    }

    public function findIDOffset($id) {
        // todo
    }

    public function returnError($message) {
        $this->output['error'] = $message;
        $this->returnOutput();
    }

    public function bufferFileLine() {

    }

    // todo in order to handle all json files, this should parse json structure and not rely on whitespace.
    public function getFileData($count = null) {
        if($count === null) { $count = self::BUFFER_SIZE; }

        echo "{\n";

        for($i = 0; $i < $count; $i++) {
            // stop the loop if we're at the end of the file.
            if(feof($this->fileHandle)) { break; }

            // get the next line
            $line = trim(fgets($this->fileHandle));

            // if the line is a [ character, skip it and continue
            if($line === "{") { $count++; continue; }
            // if the end of file somehow didn't get triggered or
            // we're on the last line, stop the loop
            else if($line === "}" || $line === false || $line === null) { break; }

            // remove any trailing comma if we're on the last iteration
            if( ($i+1) >= $count) { $line = rtrim($line, ','); }

            echo $line."\n";
        }
        //echo ',{"i": '.$i.'}'; // debug
        echo "}";

        $this->returnOutput();
    }

    public function openOrCreateFile($readOnly = false) {
        // Hard-coded filename with path to read/write to.
        $this->filename = $_SERVER['DOCUMENT_ROOT'].self::DATA_FILENAME;
        $error = "";

        try {
            $this->fileHandle = fopen($this->filename, 'r+');
            /*
            if($readOnly) {
                // Just open the file for reading
                $this->fileHandle = fopen($this->filename, 'r');
            } else {
                // create the file if needed
                $this->fileHandle = fopen($this->filename, 'w+');
            }
            */
        } catch(Exception $e) {
            $this->output['test'] = "got here. Exception thrown!";
            $this->fileHandle = null;
            $error = $e->getMessage();
        }

        if(!$this->fileHandle) {
            $this->output['message'] = $error;
            $this->returnError("Data file could not be opened.");
        }
    }

    public function returnOutput() {
        // Close the file if it's been opened
        if($this->fileHandle) { fclose($this->fileHandle); }

        // Output any output if it exists, then clear the output buffer

        if($this->output && count($this->output) > 0) {
            echo json_encode($this->output);
            $this->output = [];
        }

        exit;
    }
}

/*
if ($handle) {
    // seek to the end
    fseek($handle, 0, SEEK_END);

    // are we at the end of is the file empty
    if (ftell($handle) > 0)
    {
        // move back a byte
        fseek($handle, -1, SEEK_END);

        // add the trailing comma
        fwrite($handle, ',', 1);

        // add the new json string
        fwrite($handle, json_encode($event) . ']');
    }
    else
    {
        // write the first event inside an array
        fwrite($handle, json_encode(array($event)));
    }

        // close the handle on the file
        fclose($handle);
}
*/

header('Content-Type: application/json');
$helper = new GembudgeHelper();
$helper->returnOutput();


