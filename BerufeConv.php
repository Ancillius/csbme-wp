<?php
/**
 * Created by PhpStorm.
 * User: nils
 * Date: 17.06.15
 * Time: 08:51
 */

class BerufeConv {
    CONST AUSSTELLER = 2;
    CONST BERUF = 0;
    CONST DAUER = 3;
    CONST BAU = 4;
    CONST RAUM = 5;

    private $carddata = null;
    private $filename = 'Berufe2015.csv';

    private function getLines(){
        $handle = $this->getReadFilHandler();
        $beruf = [];
        $berufsfeld = null;
        while ($data = fgetcsv($handle,1000,";")) {
            if(empty($data[0])) continue;

            if (empty($data[2])) {
                $berufsfeld = $data[0];
                continue;
            }
            $beruf[$berufsfeld][] = $data;
        }
        return $beruf;
    }

    private function getReadFilHandler() {
      return fopen($this->filename, 'r');
    }

    public function renderHtml() {
        ob_start();
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

        <?php
        $head = ob_get_contents();
        ob_end_clean();
        echo $head;
        $data = $this->getLines();
        echo '<div class = "jobcardWrap row bootstrap">';
        $x=0;
        $bnr = 0;
        foreach ($data as $berufsfeld => $beruf) {
            $bnr++;
            $index = 0;
            ob_start();
            ?>
            <li role="presentation" class="dropdown">
                <a href="#<?=$bnr?>" id="<?= $bnr ?>" class="dropdown-toggle" data-toggle="dropdown" aria-controls="<?=$bnr?>-contents" aria-expanded="false"><?=$berufsfeld?> <span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="<?=$bnr?>" id="<?=$bnr?>-contents">
            <?php
            $liHead[$bnr] = ob_get_contents();
            ob_end_clean();
            foreach ($beruf as $index => $carddata) {
                $index++;
                $this->carddata = $carddata;
                $titel = $this->getBerufsTitel();
                $aussteller = $this->getBerufsAussteller();
                $dauer = $this->getBerufsDauer();
                $raum = $this->getBerufsRaum();
                $bau = $this->getBerufsBau();
                ob_start();
                ?>
                <li><a href="#content-<?=$bnr.$index?>" role="tab" id="<?=$bnr.$index?>-tab" data-toggle="tab" aria-controls="content-<?=$bnr.$index?>" aria-expanded="true"><?=$titel?></a></li>
                <?php
                $liItem[$bnr][$index] = ob_get_contents();
                ob_end_clean();
                ob_start();
                ?>
                <div role="tabpanel" class="tab-pane fade" id="content-<?=$bnr.$index?>" aria-labelledby="<?=$bnr.$index?>-tab">
                    <a name="content-<?=$bnr.$index?>"></a>
                    <p>Titel: <?=$titel?> <br/>Aussteller: <?=$aussteller?> <br/>Bau: <?=$bau?> <br/>Raum: <?=$raum?> <br/> Dauer: <?=$dauer?></p>
                </div>
                <?php
                $liContent[$bnr.$index] = ob_get_contents();
                ob_end_clean();

            };
        }

            echo '<div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">';
            //echo '<ul id="myTabs" class="nav nav-tabs" role="tablist">';
            echo '<ul id="myTabs" class="nav nav-pills nav-stacked" role="tablist">';

        foreach ($liHead as $bnr => $menuTab) {
            echo $menuTab;
            ob_start();
            ?>
            <ul class="dropdown-menu" aria-labelledby="<?=$bnr.'-items'?>" id="<?=$bnr.'-items'?>-contents">
            <?php
            echo ob_get_contents();
            ob_end_clean();

            foreach($liItem[$bnr] as $index => $item) {
                echo $item;
            }
            echo '</ul>';
        }
        echo '</ul>';

        echo '<div id="myTabContent" class="tab-content" style="width: 40%;border-radius: 7px;background-color: cornsilk;color: black;margin: 2em auto;box-shadow: 1em 1em 10px;padding: 1em 2em;">';
        foreach ($liContent as $index => $content) {
            echo $content;
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        ob_start();
        ?>
                <script>jQuery(function() { jQuery("a[aria-controls]").click(function() { location.hash = $(this).attr('aria-controls') }) })</script>
        <?php
        echo ob_get_contents();
        ob_end_clean();

    }

    public function getBerufsTitel() {
        return $this->carddata ? $this->carddata[self::BERUF] : '';
    }

    public function getBerufsAussteller() {
        return $this->carddata ? $this->carddata[self::AUSSTELLER] : '';
    }

    public function getBerufsRaum() {
        return $this->carddata ? $this->carddata[self::RAUM] : '';
    }

    public function getBerufsBau() {
        return $this->carddata ? $this->carddata[self::BAU] : '';
    }

    public function getBerufsDauer(){
        return $this->carddata ? $this->carddata[self::DAUER] : '';
    }

    public function run() {
        $this->renderHtml();
    }
}

class BerfufeCons2 {
    public function echoMe2() {
        echo "Doofe Welt";
    }
}

$start = new BerufeConv();
$start->run();
/**
<div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade" id="home" aria-labelledby="home-tab">
        <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
        <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
      </div>
      <div role="tabpanel" class="tab-pane fade active in" id="dropdown1" aria-labelledby="dropdown1-tab">
        <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="dropdown2" aria-labelledby="dropdown2-tab">
        <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
      </div>
    </div>
 * **/