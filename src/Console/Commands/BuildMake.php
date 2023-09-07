<?php

namespace Jiny\Build\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;


class BuildMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'static build';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Static Build");

        // 출력폴더 생성
        $path = base_path().DIRECTORY_SEPARATOR."docs";
        if(!is_dir($path)) {
            $this->info("creating docs folder");
            mkdir($path);
        }


        $path = resource_path("views".DIRECTORY_SEPARATOR."pages");
        $this->scanDir($path);

        // 출력
        /*
        $obj = view("welcome");
        $body = $obj->__toString();
        $body = str_replace("http://localhost/","/",$body);
        file_put_contents($path.DIRECTORY_SEPARATOR."welcom".".html", $body);
        */



        /*
        $email = $this->argument('email');

        $isAdmin = $this->option('enable') ? 1:0;
        if($this->option('disable')) {
            $this->disableAdmin($email);
        } else {
            $this->enableAdmin($email);
        }



        if($isAdmin) {
            $this->info('Success : '. $email." is Admin user");
        } else {
            $this->info('Success : '. $email." is normal user");
        }
        */

        return 0;
    }

    private function scanDir($path)
    {
        $pagePath = resource_path("views".DIRECTORY_SEPARATOR."pages");

        $dir = scandir($path);
        foreach($dir as $name) {
            if($name == "." || $name == "..") continue;
            // 디렉터리인 경우, 재귀호출
            if(is_dir($path.DIRECTORY_SEPARATOR.$name)) {
                $this->scanDir($path.DIRECTORY_SEPARATOR.$name);
            } else
            // 파일인 경우
            {
                $filename = str_replace($pagePath,"",$path.DIRECTORY_SEPARATOR.$name);
                $this->info($filename);

                $fileinfo = pathinfo($path.DIRECTORY_SEPARATOR.$name);
                //dump($fileinfo);
                $filePath = str_replace($pagePath,"",$fileinfo['dirname']);
                //dump($filePath);

                // 디렉터리가 없는 경우 생성
                $base = base_path("docs");


                if(!is_dir($base.$filePath)) {
                    //dd($base.$filePath);
                    mkdir($base.$filePath,777, true);
                }


                $ext = $fileinfo['extension'];
                switch($ext) {
                    case "php":
                        $filename = ltrim($filename,"\\");
                        $filename = str_replace(".blade.php","",$filename);
                        $filename = str_replace(["\\","/"],".",$filename);

                        //dd($filename);
                        $obj = view("pages.".$filename);
                        $body = $obj->__toString();
                        $body = str_replace("http://localhost/","/",$body);
                        //dd($base.$filePath.DIRECTORY_SEPARATOR.$filename.".html");
                        file_put_contents($base.$filePath.DIRECTORY_SEPARATOR.$filename.".html", $body);

                        break;
                    case "md":

                        $filename = ltrim($filename,"\\");
                        $filename = str_replace(".md","",$filename);



                        //dd($filename);
                        //$obj = view("pages.".$filename);
                        //$body = $obj->__toString();
                        //$body = str_replace("http://localhost/","/",$body);
                        //dd($base.$filePath.DIRECTORY_SEPARATOR.$filename.".html");

                        //dd($path.DIRECTORY_SEPARATOR.$name);
                        $markdown = file_get_contents($path.DIRECTORY_SEPARATOR.$name);

                        // 마크다운 변환
                        $Parsedown = new \Parsedown();
                        $html = $Parsedown->text($markdown);

                        //dd($base.DIRECTORY_SEPARATOR.$filename.".html");
                        file_put_contents($base.DIRECTORY_SEPARATOR.$filename.".html", $html);


                        break;
                }



            }
        }
        return 0;
    }




}
