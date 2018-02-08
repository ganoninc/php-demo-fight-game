<?php

/**
 * A fight game demonstration made as a technical evaluation
 *
 * @author  Romain Giovanetti <rgiovanetti@outlook.com>
 */

/**
 * A player
 */ 
class Player{
    private $name = "";
    private $lifeValue = 0;
    private $offenseLevel = 0;
    private $defenseLevel = 0;

    /** 
     * Set name's value
     */
    public function setName($name){
        $this->name = $name;
    }
    /** 
     * Get name's value
     * 
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /** 
     * Set life's value
     */
    public function setLifeValue($lifeValue){
        $this->lifeValue = $lifeValue;
    }
    /** 
     * Get life's value
     * 
     * @return int
     */
    public function getLifeValue(){
        return $this->lifeValue;
    }

    /** 
     * Set offenseLevel's value
     */
    public function setOffenseLevel($offenseLevel){
        $this->offenseLevel = $offenseLevel;
    }
    /** 
     * Get offenseLevel's value
     * 
     * @return int
     */
    public function getOffenseLevel(){
        return $this->offenseLevel;
    }

    /** 
     * Set defenseLevel's value
     */
    public function setDefenseLevel($defenseLevel){
        $this->defenseLevel = $defenseLevel;
    }
    /** 
     * Set defenseLevel's value
     * 
     * @return int
     */
    public function getDefenseLevel(){
        return $this->defenseLevel;
    }

    /** 
     * Return a string representation of a player
     * 
     * @return string
     */
    public function toString(){
        return $this->name." (Live value:".$this->lifeValue.", Offense level:".$this->offenseLevel.", Defense level:".$this->defenseLevel.")";
    }
}

/**
 * A fight game
 */ 
class FightGame
{
    private $playerOne;
    private $playerTwo;
    // if it's not the player one's turn, then it's the player two's one
    private $isPlayerOnesTurn = true;

    public function __construct()
    {
        $this->playerOne = new Player();
        $this->playerTwo = new Player();
    }

    /**
     * Update players' properties according to the rules of the fight game
     */
    private function applyTurnsEffects($punchNumber, $sourcePlayer, $destinationPlayer){
        $sourcePlayer->setOffenseLevel($sourcePlayer->getOffenseLevel() + $punchNumber);

        $destinationPlayerDefenseLevel = $destinationPlayer->getDefenseLevel();
        $destinationPlayerImpactLevel = $punchNumber - $destinationPlayerDefenseLevel;
        $destinationPlayer->setLifeValue($destinationPlayer->getLifeValue() - $destinationPlayerImpactLevel);
    }

    /**
     * Pick a random number as punch value and then apply the effets according to who is the thrower.
     * Then, it switches isPlayerOnesTurn's value according to the previous thrower for the next turn.
     */
    private function playTurn(){
        echo(PHP_EOL."New turn!".PHP_EOL);
        $punchNumber = random_int(0, 100);
        if($this->isPlayerOnesTurn){
            $this->applyTurnsEffects($punchNumber, $this->playerOne, $this->playerTwo);
        }else{
            $this->applyTurnsEffects($punchNumber, $this->playerTwo, $this->playerOne);
        }
        $this->isPlayerOnesTurn = !$this->isPlayerOnesTurn;
        echo("\t- ".$this->playerOne->toString().PHP_EOL);
        echo("\t- ".$this->playerTwo->toString().PHP_EOL);
    }

    /** 
     * Check if one of the players is dead, if this is the case, the party is over
     * 
     * @return boolean
     */
    private function isOver(){
        return $this->playerOne->getLifeValue() < 1 || $this->playerTwo->getLifeValue() < 1;
    }

    /**
     * Init. the two players of the game with arbitrary given values
     */
    public function initThePlayers(){
        $this->playerOne->setName("Player One");
        $this->playerOne->setLifeValue(100);
        $this->playerOne->setOffenseLevel(0);
        $this->playerOne->setDefenseLevel(25);
        echo("Here is the player one:".PHP_EOL);
        echo("\t- ".$this->playerOne->toString().PHP_EOL);

        $this->playerTwo->setName("Player Two");
        $this->playerTwo->setLifeValue(100);
        $this->playerTwo->setOffenseLevel(0);
        $this->playerTwo->setDefenseLevel(25);
        echo("Here is the player two:".PHP_EOL);
        echo("\t- ".$this->playerTwo->toString().PHP_EOL);
    }

    /**
     * Simulate a party by playing successive turns until one of the player is dead
     */
    public function play(){
        $this->initThePlayers();
        echo(PHP_EOL."3...2...1... GO!".PHP_EOL);

        while(!$this->isOver()){
            $this->playTurn();
        }
        echo(PHP_EOL."GAME!".PHP_EOL);
        $winner = $this->playerOne->getName();
        if($this->playerTwo->getLifeValue() > $this->playerOne->getLifeValue())
            $winner = $this->playerTwo->getName();
        echo("\tThe winner is: ".$winner."!".PHP_EOL);
    }
}

echo("=== Super Fight Game ===".PHP_EOL.PHP_EOL);
// Let's create a new FightGame...
$game = new FightGame();
// ...and launch a party
$game->play();

?>