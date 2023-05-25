# rockscissorspaper
Traditional game. Rock beats scissors, scissors cut paper, paper wraps rock.

A little Command Line Interface project to play classic game.
Game launches by "php index.php app:game {arguments}" command where {arguments} is a list of usable weapons.

According to rules there should be at least 3 or more odd (3, 5, 7 etc.) unique weapons.
Each weapon beats the following half of weapons and is beaten by previous half of weapons, i.e.:

If there are 5 weapons (Rock Scissors Paper Lizard Spock), then Paper is stronger than Lizard and Spock, however,
it is weaker than Rock and Scissors (in this scenario).

When game launches, the computer takes initiative and chooses its weapon.
Game generates secure random key and calculates HMAC based on the move and the key.

After that the player receives "menu" "1 - Rock, 2 - Scissors, ..., 0 - exit, ? - help".

Player makes his choice.
Game shows both Player's and computer's moves, results of the battle (player win / player lose / draw)
and the original key.

With this information the player cold check that the computer did not change his move during the current game,
so it did not cheat (for example player could use resource https://techiedelight.com/tools/hmac, algorithm is SHA3-256).

When the player selects 'help' option, the help table is shown with all possible variants of the current game.