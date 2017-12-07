<div class="row">
            <div class="col-sm-5">
                <h1>Eintrag ändern</h1>
                <p>Hier kannst du Deinen Eintrag ändern/erstellen</p>
            </div>
        </div>
<div class="row">
    <div class="col-sm-6 alert alert-info">
        <p> Der <?php echo $_GET["dateOutput"] ?> ist ein <?php echo $_GET["day"] ?>. Normalerweise hättest Du <?php echo $_GET["regularHours"]?> Stunden gearbeitet.
        Aufgrund der bishereigen Daten hast Du an diesem Tag <?php echo $_GET["workingHours"] ?> Stunden gearbeitet.
        Dies ergibt eine Abweichung von <?php echo $_GET["balance"] ?> Stunden.
        Bis zu diesem Datum hat dein Überstundenkonto einen Saldo von <?php echo $_GET["balanceTotal"] ?> Stunden.</p>
    </div>
</div>
<div class="row">
    <form class="col-sm-6" method="post" action="change-entry.php">
        <div class="row">
            <div class="form-group">
                    <input type="hidden" id="date" name="date" value="<?php echo  $_GET["date"]?>">
            </div>
            <div class="form-group">
                    <input type="hidden" id="user" name="user" value="<?php echo  $_GET["user"]?>">
            </div>
            <div class="row">
                <div class="form-group col-sm-2">
                        <lable for="begin">Anfang<br></lable>
                        <input class="form-controll" type="time" id="begin" name="begin" value="<?php echo  $_GET["begin"]?>">
                </div>
                <div class="form-group col-sm-2">
                    <lable for="end">Ende<br></lable>
                    <input class="form-controll" type="time" id="end" name="end" value="<?php echo $_GET["end"]?>">
                </div>
            </div>
            <div class="row">
                <div class=" col-sm-4 form-group">
                    <lable for="break">Pause</lable>
                    <input class="form-controll" type="number" id="break" name="break" value="<?php echo $_GET["break"]?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Absenden</button>
        </div>
    </form>
</div>