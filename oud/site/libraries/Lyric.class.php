<?php

class Lyric {
	
	public $full_text		= "";
	public $stringlist		= array();
	public $total_words		= 0;
	
	public function __construct($text)
	{
		$this->full_text	= $text;
		$this->stringlist	= array_count_values(str_word_count(strtolower($this->full_text), 1));
		$this->total_words	= count($this->stringlist);
		asort($this->stringlist);
	}
	
	public function analyze()
	{
		$ret		= array();
		$ret[0]		= $this->countWords("happy.txt")/$this->total_words;
		$ret[1]		= $this->countWords("sad.txt")/$this->total_words;
		return $ret;		
	}
	
	public function printList()
	{
		print_r($this->stringlist);
	}
	
	private function countWords($filename)
	{
		$file		= file($filename);
		
		$count			= 0;
		foreach($file as $string)
		{
			$count		+= $this->stringlist[strtolower(trim($string))];
		}
		
		return $count;
	}
}

$t		= new Lyric("Another tactic to get my heart broken
Another tactic to get upset and cry
'Cos I never leave my heart open
Never hurts me say goodbye
Relationships don´t get deep to me
Never got the whole in love thing
And someone can say they loved me truly
But at the time it don´t mean a thing

My mind is gone
I´m spinning round
And deep inside
My tears ill drown
I´m loosing grip
What´s happening?
I stray from love
This is how I feel

[CHORUS]
This time was different
Felt like I was just a victim
And it cut me like a knife
When you walked out of my life
Now I´m in this condition
And I got all the symptoms
Of a girl with a broken heart
But no matter what
You´ll never see me cry

Did it happen when we first kiss?
Cos it´s hurting me let it go
Maybe cos we spent so much time
And I know that is no more
I should have never let you hold me baby
Maybe why I´m sad to see us apart
I didn´t give it to you on purpose
can't figure out how you stole my heart

My mind is gone
I´m spinning round
And deep inside
My tears ill drown
I´m loosing grip
What´s happening?
I stray from love
This is how I feel

[CHORUS]
This time was different
Felt like I was just a victim
And it cut me like a knife
When you walked out of my life
Now I´m in this condition
And I got all the symptoms
Of a girl with a broken heart
But no matter what
You´ll never see me cry

How did I get here with you
I´ll never know
I never meant to let it get so personal
And after all I tried to do
Stay away from love with you
I´m broken-hearted
I can´t let you know
And I Won´t Let It Show
You won´t see me cry

[CHORUS]
This time was different
Felt like I was just a victim
And it cut me like a knife
When you walked out of my life
Now I´m in this condition
And I got all the symptoms
Of a girl with a broken heart
But no matter what
You´ll never see me cry

[REPEAT]
This time was different
Felt like I was just a victim
And it cut me like a knife
When you walked out of my life
Now I´m in this condition
And I got all the symptoms
Of a girl with a broken heart
But no matter what
You´ll never see me cry

all my life..

Looking back it's hard for me to see 
Just how I could have been so blind 
Like an actor on a movie screen 
You played the part with every line 
Well every story doesn't have a happy ending 
Sometimes a flower doesn't grow 

I hope you understand the message that I'm sending 
But boy I think you need to know 

(coulda been the one) 
That I would give it all to catch you when you fall boo 
(Shoulda been the one) 
Didn't know just what you had boy 
Now it's just too bad boy 
(After all is said and done) 
You're a cheater and a liar 
Went to play with fire 
Boy I hope that you enjoyed your fun 
Cuz you coulda been the one 

There's nothing left to say 
Coulda been the one 
Coulda been 
Shoulda been 

My momma didn't raise no fool 
She said play with fire you get burned 
You laughed at me, I laugh at you 
Now it seems the table's turned 
I must admit I really thought you had potential 
But I could not have been more wrong 
I need somebody I can trust with his essentials 
You had your chance but now I'm long gone 

(coulda been the one) 
I would give it all to catch you when you fall boo 
(Shoulda been the one) 
Didn't know just what you had boy 
Now it's just too bad boy 
(After all is said and done) 
You're a cheater and a liar 
Went to play with fire 
Boy I hope that you enjoyed your fun 
Cuz you coulda been the one 

You coulda been the one baby 
(You coulda been the one) 
Oh yeah 

You played yourself boy 
And there is no denying it 
It's just the way the story goes 
You made your bed boy 
Better go and lay in it 
But know that you'll be laying there alone 

You coulda been the one 

(coulda been the one) 
I would give it all to catch you when you fall boo 
(Shoulda been the one) 
Didn't know just what you had boy 
Now it's just too bad boy 
(After all is said and done) 
You're a cheater and a liar 
Went to play with fire 
Boy I hope that you enjoyed your fun 
Cuz you coulda been the one

That´s how much I love you
That´s how much I need you

[Rihanna]
And I can´t stand ya'
Must everything you do make me wanna smile?
Can I not like it for awhile?

(No...)

[Ne-Yo]
But you won´t let me
You upset me girl, then you kiss my lips
All of a sudden I forget (that I was upset)
Can´t remember what you did

(But I hate it)

[Rihanna]
You know exactly what to do
So that I can´t stay mad at you
For too long, that´s wrong

(But, I hate it)

[Ne-Yo]
You know exactly how to touch
So that I don´t wanna fuss and fight no more
So I despise that I adore you

[Rihanna]
And I hate how much I love you boy
I can´t stand how much I need you
And I hate how much I love you boy
But I just can´t let you go
And I hate that I love you so..

[Ne-Yo]
And you completely know the power that you have
The only one that makes me laugh

[Rihanna]
Sad and it´s not fair how you take advantage of the fact that I
Love you beyond the reason why
And it just ain´t right

[Ne-Yo]
And I hate how much I love you girl
I can´t stand how much I need you
And I hate how much I love you girl
But I just can´t let you go
And I hate that I love you so

[Rihanna and Ne-Yo]
One of these days maybe your magic won´t affect me
And your kiss won´t make me weak
But no one in this world knows me the way you know me
So you´ll probably always have a spell on me


That´s how much I love you
That's how much I need you

That´s how much I love you
That´s how much I need you

[Rihanna]
And I hate that I love you so--
And I hate how much I love you boy
I can´t stand how much I need you
And I hate how much I love you boy
But I just can´t let you go
And I hate that I love you so

And I hate that I love you so...

So...

The golden light about you shows me where you're from 
The magic in your eye bewitches all you gaze upon 
You stand up on your hill and they bebop all around you 
They wonder where you're from oh yeah 
They wonder where I found you 
Oh my love it's a long way 
Where you're from it's a long way 

I tried to understand you, I tried to love you right 
The way you smile and touch me always sets my heart alight 
Your lips are like a fire burning through my soul 
And people ask me where you're from 
They really wanna know 
Oh my soul it's a long way 
Where you're from it's a long way 

Magic woman wreckin' up my soul 
Things you tell me have never been told 
Magic woman I don't know 
Electric before me I love you so I love you so 
You're racing like a fireball dancing like a ghost 
You're gemini and I don't know which one I like the most 
My head is getting broken and my mind is getting bust 
But now I'm coming with you down the road of golden dust 
Oh my love it's a long way 
Where you're from it's a long way

Red red wine goes to my head 
Makes me forget that I still need you so 

Red red wine 
It's up to you 
All I can do I've done 
Memories won't go 
Memories won't go 

I have sworn every time 
Thoughts of you would leave my head 
I was wrong, now I've found 
Just one thing makes me forget... 

Red red wine 
Stay close to me 
Don't let me be alone 
It's tearing apart 
My blue blue heart 

I have sworn every time 
Thoughts of you would leave my head 
I was wrong, now I've found 
Just one thing makes me forget... 

Red red wine 
Stay close to me 
Don't let me be alone 
It's tearing apart 
My blue blue heart 

repeat last verse

Red, red wine 
Makes me forget that I still need her so 
Red, red wine goes to my head 

Red, red wine, it's up to you 
All I can do I've done 
Memories won't go, memories won't go 

I'd have sworn, that with time 
Thoughts of you would leave my head 
I was wrong, now I find 
Just one thing makes me forget 

Red, red wine, stay close to me 
Don't let me be alone 
It's tearing apart my blue heart 
I'd have sworn, that with time 

Thoughts of you would leave my head 
I was wrong, now I find 
Just one thing makes me forget 
Red, red wine, stay close to me 

Don't let me be alone 
It's tearing apart my blue blue heart 
Red red wine, you make me feel so fine 

You keep me rockin' all of the time 
Red red wine, you make me feel so grand 
Red red wine, you make me feel so sad 
I feel a million dollar when you're just in my hand 
Red red wine, you make me feel so fine 
Any time I see you go, it make me feel bad 

Monkey back and ease up on the sweet deadline 
Red red wine, you give me holy pahzing 
Holy pahzing, you make me do my own thing 
Red red wine, you give me not awful love 
Your kind of lovin' like a blessing from above 
Right from the start, with all of my heart 
Red red wine, I loved you right from the start 
Red red wine in an eighties style 
Red red wine in a modern beat style 
Yeah 

Give me a little time, let me clear out my mind 
Give me a little time, let me clear out my mind 
Give me red wine, the kind make me feel fine 
You make me feel fine all of the time 
Monkey back and ease up on the sweet deadline 
Red red wine, you make me feel so fine 
The line broke, the money get choked 
Bunbah, ganjapani, little rubber boat 
Red red wine, I'm gonna love you till I die 
Red red wine, I'm gonna hold on to you 
Hold on to you 'cause I know you love truth 
Love you till I die, and that's no lie 
Red red wine, can't get your off my mind 
I'll surely find, Make no fuss, just leave us 
Wherever you may be, I'll surely find 
Give me a little time, let me clear out my mind 

Give me a little time, let me clear out my mind 
Give me red wine, the kind make me feel fine 
You make me feel fine all of the time 
Red red wine, you make me feel so fine 
Monkey back and ease up on the sweet deadline 
The line broke, the money get choked 
Bunbah, ganjapani, little rubber boat 

Red red wine, you give me not awful love 
Your kind of lovin' like a blessing from above 
Red red wine, I loved you right from the start 
Red red wine, you give me holy pahzing 
Right from the start, with all of my heart 
Holy pahzing, you make me do my own thing 
Red red wine in an eighties style 
Red red wine in a modern beat style 
Yeah

Rood is al lang het rood niet meer 
Het rood van rode rozen 
De kleur van liefde van weleer 
Lijkt door de haat gekozen 

Dat mooie rood was ooit voor mij 
Een kleur van passie en van wijn 
Ik wil haar terug, die mooie tijd 
Maar zij lijkt lang vervlogen 

En alle beelden op tv 
Van bloed en oorlog om ons heen 
Werken daar ook niet echt aan mee 

Dus ik neem heel bewust het besluit 
De krant leg ik weg 
En de tv gaat uit 

Vandaag is rood de kleur van jouw lippen 
Vandaag is rood wat rood hoort te zijn 
Vandaag is rood 
Het rood van rood wit blauw 
Van heel mijn hart voor jou 
Schreeuw van de roodbedekte daken dat ik van je hou 
Vandaag is rood gewoon weer liefde tussen jou en mij 

Ik loop de deur door en naar buiten waar de zon begint te schijnen 
Laat alles achter, kijk vooruit en met mijn laatste rooie cent 
Koop ik een veel te grote bos met honderdvijftig rode rozen 
Een voor elk jaar waarvan ik hoop dat jij nog bij me bent 

Vandaag is rood de kleur van jouw lippen 
Vandaag is rood wat rood hoort te zijn 
Vandaag is rood 
Het rood van rood wit blauw 
Van heel mijn hart voor jou 
Schreeuw van de roodbedekte daken dat ik van je hou 
Vandaag is rood gewoon weer liefde tussen jou en mij 

En nu sta je hier zo voor me 
De rode avondzon streelt jouw gezicht 
Je bent een wonder voor me 
Denk ik, terwijl een doorn mijn vinger prikt 

Rood is mijn bloed dat valt op de grond 
En even lijk ik verloren 
Maar jij brengt mijn vingers naar je mond 

En je kust ze 
En ik weet 

Vandaag is rood de kleur van jouw lippen 
Vandaag is rood wat rood hoort te zijn 
Vandaag is rood 
Het rood van rood wit blauw 
Van heel mijn hart voor jou 
Schreeuw van de roodbedekte daken dat ik van je hou 
Vandaag is rood gewoon weer liefde tussen jou en mij 

Vandaag... is rood 

Gooi de loper uit 
En drink een goed glas wijn 
Pluk de dag want het kan zo ineens de laatste zijn 
Vandaag is rood gewoon weer liefde tussen jou en mij 

Vandaag staat rood weer voor de liefde 
Tussen jou en mij 

Voor altijd bij elkaar, 
mijn armen om je heen, 
mijn allergrootste liefde, 
dat wist ik echt meteen, 
De allerlaatste weken, 
de dagen gingen snel, 
dichtbij komt het afscheid, 
moeilijk wordt het wel. 

Zeg dat je niet hoeft te gaan, schat, 
dat je aan mij echt genoeg had, 
zeg dat je niet hoeft te gaan schat, 
ga schat, want je moet, ik weet je moet. 

Als het even kon dan, 
bleef ik nog een nacht bij jouw, 
als het even kon dan, 
bleef iknog een nacht bij jouw, 
dan zou ik zeggen dat ik op je wacht, 
dat de toekomst naar ons lacht, 
dan zou ik zeggen voor de zoveelste keer: 
ik wil geen ander nooit meer. 

De koffers staan al buiten, 
de achterklep slaat dicht, 
een laatste lange kus, 
in het vroege ochtendlicht, 
je kijkt me liefjes aan, 
en pakt me stevig beet, 
ik fluister in je oor, 
dat ik je niet vergeet. 

Zeg dat je niet hoeft te gaan, schat, 
dat je aan mij echt genoeg had, 
zeg dat je niet hoeft te gaan schat, 
ga schat, want je moet, ik weet je moet. 

Als het even kon dan, 
bleef ik nog een nacht bij jouw, 
als het even kon dan, 
bleef iknog een nacht bij jouw, 
dan zou ik zeggen dat ik op je wacht, 
dat de toekomst naar ons lacht, 
dan zou ik zeggen voor de zoveelste keer: 
ik wil geen ander nooit meer. 
Nooit meer zal ik voelen wat ik voel voor jouw, 
ik hoop dat ik kan leven zonder jouw, 
kom, ga nu maar, veeg je tranen weg, 
en onthou heel goed dat ik van je hou, 
van je hou. 

Nee, nee, nee, je hoeft niet te gaan schat, neeeee... 
Nee, nee, nee, je hoeft niet te gaan schat, neeeee... 

Open mijn ogen 
Kijk om me heen 
Alles lijkt veranderd 
Mijn buik doet raar en ik voel me vreemd 

En ik vraag me af wat dit gevoel veroorzaakt heeft 
Mijn gedachten lijken zelfs niet meer van mij 
Kan mezelf niet vinden 
En de reden dat ben jij 

Je bent binnen 
binnen in mijn hart 
binnen in mijn ziel 
Van binnen 
binnen sinds de dag dat ik voor jou viel 
binnen 
binnen in de droom die ik met je wil beginnen 
je bent binnen 
binnen.... 

het leven werd door mij alleen geregisseerd 
maar zonder iets te zeggen (met mezelf te overleggen) 
heb ik alle rollen omgekeerd 
en ik vraag me af waarom ik doe wat ik nu doe 
maar het antwoord op die vraag komt niet van mij 
ik lijk gek te worden 
en de reden dat ben jij 

Je bent binnen 
binnen in mijn hart 
binnen in mijn ziel 
Van binnen 
binnen sinds de dag dat ik voor jou viel 
binnen 
binnen in de droom die ik met je wil beginnen 
je bent binnen 
binnen.... 

Ik zit bij jou achterop de fiets 
we gaan steeds iets harder 
ik zie bijna niets 
ik sta voor de keuze 
nu er af of voor altijd mee 
ik besluit de angsten van me af te slaan 
en voor altijd met je mee te gaan 
mn hoofd tegen je rug gedrukt 
en mijn armen om je heen.... 

Binnen! 
Binnen in mn hart binnen in mn ziel 
van binnen 
binnen sinds de dag dat ik voor jou viel 
binnen 
binnen in de droom die ik met je wil beginnen 
je bent binnen 

heejiejeeeeeeeeeee hheeeeeeeeeeeeejjieeejeeeeeeeeee 
heejiejieheeeeeeeeeeeeeeeeeejieheeeeeeeeeeeeeeeee 
(etcetera) 

binnen in mijn hart binnen in mijn ziel 
binnen sinds de dag dat ik voor je viel 
als ik van je droom 
als ik denk als ik werk als ik vrij ben 
als ik me verveel of mezelf weer eens kwijt ben 

heejiejeeeeeeeeeeeeeeeee 

je bent binnen 

heejiejeeeeeeeeeeeeee 

je bent binnen 
je bent binnen 
hejjieeeeeeeeeee hee

Ik weet niet hoe of wat er met jou is gebeurd 
Je hoort niet meer bij mij 
Iedere dag begin je weer met dat gezeur 
Je bent veel liever vrij 
Je hebt het vaak genoeg gezegd 
De deur staat open, jij mag weg 

Dus laat maar los 
Ga maar vliegen nu het kan 
Leef je eigen leven 
En geniet er lekker van 
Laat maar los 
Je bent nog veel te veel van plan 
En ik vlieg niet met je mee 
Dus laat maar los 

Ik kan niet begrijpen dat ik het niet heb gezien 
Dat je zo anders bent 
Het zou kunnen zijn dat ik het niet wilde, misschien 
Maar ik heb het nooit herkend 
Ik zal je niet in de weg gaat staan 
De deur staat open, jij kunt gaan 

Laat maar los 
Ga maar vliegen nu het kan 
Leef je eigen leven 
En geniet er lekker van 
Laat maar los 
Je bent nog veel te veel van plan 
en ik vlieg niet met je mee 

Dus maak je hart weer vrij 
Maar krijg vooral geen spijt 
Want eenmaal weg bij mij 
Is voor altijd 

Dus laat maar los 
Ga maar vliegen nu het kan 
Leef je eigen leven 
En geniet er lekker van 
Laat maar los 
Je bent nog veel te veel van plan 
En ik vlieg niet met je mee 

Dus laat maar los 

Laat maar los 

Dus laat maar los 
Ga maar vliegen nu het kan 
Maar ik vlieg niet met je mee 
Dus laat maar los

They rise above this,
They cry about this,
As we live and learn..

A broken promise,
I was not honest,
Now I watch as tables turn,
And you´re singing -

I´ll wait my turn,
To tear inside you,
Watch you burn,
I´ll wait my turn,
I´ll wait my turn.

I´ll cry about this,
And hide my cuckold eyes,
As you come off all concerned,
And I´ll find no solace,
In your poor apology,
In your regret that sounds absurd,
And keep singing -

I´ll wait my turn,
To tear inside you,
Watch you burn..
And I´ll wait my turn,
To terrorize you,
Watch you burn..
And I´ll wait my turn,
I´ll wait my turn.

And this is a promise -
Promise is a promise,
Promise is a promise,
Promise is a promise.

And I´ll wait my turn,
To tear inside you,
Watch you burn,
I´ll wait my turn,
I´ll wait my turn.

A broken promise,
You were not honest!
I´ll bide my time
I´ll wait my, turn.

It ain?t no use to sit and wonder why, babe
It don?t matter, anyhow
An? it ain?t no use to sit and wonder why, babe
If you don?t know by now
When your rooster crows at the break of dawn
Look out your window and I?ll be gone
You?re the reason I?m trav?lin? on
Don?t think twice, it?s all right

It ain?t no use in turnin? on your light, babe
That light I never knowed
An? it ain?t no use in turnin? on your light, babe
I?m on the dark side of the road
Still I wish there was somethin? you would do or say
To try and make me change my mind and stay
We never did too much talkin? anyway
So don?t think twice, it?s all right

It ain?t no use in callin? out my name, gal
Like you never did before
It ain?t no use in callin? out my name, gal
I can?t hear you anymore
I?m a-thinkin? and a-wond?rin? all the way down the road
I once loved a woman, a child I?m told
I give her my heart but she wanted my soul
But don?t think twice, it?s all right

I?m walkin? down that long, lonesome road, babe
Where I?m bound, I can?t tell
But goodbye?s too good a word, gal
So I?ll just say fare thee well
I ain?t sayin? you treated me unkind
You could have done better but I don?t mind
You just kinda wasted my precious time
But don?t think twice, it?s all right

This town has sunk its teeth
Deep inside of me 
And now I struggle just to breath 

And this used to be my own safety 
The side walks been torn up 
And the memories are grey 
I'd rather keep them all that way 

'Cause I can't relive 
All of those nights when i was 
Afraid that i wouldn't ever be the same 
When i was shaking in a cold sweat 
Cursing all the pain I felt 
I can't go back to all this! 
(the pain I felt) 
I can't go back through all this now 

Look at me 
I'm a mess 
A mess of everything
That i never wanted to be 

I can't relive 
I can't relive 
All of those nights when I was 
Afraid that i wouldn't ever be the same 
When i was shaking in a cold sweat 
Cursing all the pain I felt
I can't go back to all this 
(the pain I felt) 
I can't go back to all this 
I can't go back to all this now 

All of those nights when i was 
Afraid that i wouldn't ever be the same 
When i was shaking in a cold sweat 
Cursing all the pain I felt 
I can't go back to all this 
(the pain I felt) 
I can't go back through all this 
I can't go back through all this now!

All the gold and the guns in the world
(couldn't get you off)
All the gold and the guns and the girls
(couldn't get you off)
All the boys, All the choices in the world

I remember when we were gambling to win
Everybody else said better luck next time
I don't wanna bend, Let the bad girls bend
I just wanna be your friend
Is it ever gonna be enough

Is it ever gonna be enough
Is it ever gonna be enough
Is it ever gonna be enough

Is it ever gonna be enough
Is it ever gonna be enough
Is it ever gonna be enough

All the lace and the skin in the shop
(couldn't get you off)
All the toys and the tools in the box
(couldn't get you off)
All the noise, all the voices never stop

I remember when we were gambling to win
Everybody else said better luck next time
I don't wanna bend, Let the bad girls bend
I just wanna be your friend
Why you givin' me a hard time
I remember when we were gambling to win
Everybody else said HA HA HA HA HA HA HA

Is it ever gonna be enough
Is it ever gonna be enough
Is it ever gonna be enough

Is it ever gonna be enough
Is it ever gonna be enough
Is it ever gonna be enough

More and more, more and more, more and more,
More and more and more and more, more and more

I'm not afraid
Of anything in this world
There's nothing you can throw at me
That I haven't already heard
I'm just trying to find
A decent melody
A song that I can sing
In my own company

I never thought you were a fool
But darling, look at you. Ooh.
You gotta stand up straight, carry your own weight
'Cause tears are going nowhere baby

You've got to get yourself together
You've got stuck in a moment
And now you can't get out of it
Don't say that later will be better
Now you're stuck in a moment
And you can't get out of it


I will not forsake
The colors that you bring
The nights you filled with fireworks
They left you with nothing
I am still enchanted
By the light you brought to me
I listen through your ears
Through your eyes I can see

You are such a fool
To worry like you do.. Oh
I know it's tough
And you can never get enough
Of what you don't really need now
My, oh my

You've got to get yourself together
You've got stuck in a moment
And you can't get out of it
Oh love, look at you now
You've got yourself stuck in a moment
And you can't get out of it
Oh lord look at you now
You've got yourself stuck in a moment
And you cant get out of it

I was unconscious, half asleep
The water is warm 'til you discover how deep
I wasn't jumping, for me it was a fall
It's a long way down to nothing at all

You've got to get yourself together
You've got stuck in a moment
And you can't get out of it
Don't say that later will be better
Now you're stuck in a moment
And you can't get out of it

And if the night runs over
And if the day won't last
And if your way should falter
Along this stony pass

It's just a moment
This time will pass

The sea it swells like a sore head and the night it is aching 
Two lovers lie with no sheets on their bed 
And the day it is breaking 

On rainy days we'd go swimming out 
On rainy days swimming in the sound 
On rainy days we'd go swimming out 

You're in my mind all of the time 
I know that's not enough 
If the sky can crack there must be someway back 
For love and only love 

Electrical Storm 
Electrical Storm 
Baby don't cry 

Car alarm won't let you back to sleep 
You're kept awake dreaming someone elses dream 
Coffee is cold but it'll get you through 
Compromise that's nothing new to you. 
Let's see colours that have never been seen 
Let's go places no one else has been 

You're in my mind all of the time 
I know that's not enough 
Well if the sky can crack there must be someway back 
To love and only love 

Electrical storm [x3] 
Baby don't cry 

It's hot as hell, honey in this room 
Sure hope the weather will break soon 
The air is heavy, heavy as a truck 
We need the rain to wash away our bad luck 

Well if the sky can crack there must be some way back 
To love and only love 

Electrical storm [x3] 

Baby don't cry [x3]

Flash a-ah 
Saviour of the universe 
Flash 
He save everyone of us 
Flash 
He's a miracle 
Flash 
King of the impossible 

He's for everyone of us 
Stand for everyone of us 
He save with a mighty hand 
Every man every woman 
Every chill - he's a mighty 
Flash 

Just a man 
With a man's courage 
Mothing but a man 
But he can never fail 
No-one but the pure in heart 
May find the Golden Grail 
.................ah................. 
Flash

Do i love you? 
Let me tell ya, 
My mona lisa with a smile, 
Knowing all that we've been through, 
Together, 
We've lasted for a while. 
Hasn't it been so easy? 
But life can be that way, 
You made all the mountains, 
Seem so small. 
'cause when there's love, 
True love, 
Nothing else matters, 
At all. 
Those precious moments, 
Are filled with so much tears and laughter; 
Funny how the time does fly. 
Was it all a plan, 
Or some passing chances? 
I won't ask the reason why. 
If i say i love you, 
Let me tell you like it is, 
Love you till the stars stars, 
All start to fall. 
'cause when there's love, 
True love, 
Nothing else matters, 
At all. 
When i say i love you, 
Let me tell you like it is, 
Love you till the stars, 
All start to fall. 
Yes when there is love, 
True love. 
Yes when there is love, 
True love. 
Yes when there is love, true love; 
Nothing else matters, 
Nothing else matters, 
Nothing else matters, 
At all......

Ten Thousand Streams and a One Day-trial 
Can't Stand the Strain Pushing Me to Plunge 
Look How the Tide Embraces Wings 
Down That River 
To a Sea of Walking Dreams 
Down That River 
Stop the World, I Leave 
Free-crime, I Shoot the Stars 

Fireworks Matching the Day Where Nothing Else Goes 
Blow Your Mind and Remain Where Nothing Else Goes 
Bleed Your Heart to the Day Where Nothing Else Goes On 

Sometimes I Dream I Can Shoot the Stars 
Light Up the Fireworks and Guide the Time 
Look How the Tide Embraces Wings 
Down That River 
Stop the World, I Leave 
Free-crime, I Shoot the Stars 

Fireworks Matching the Day Where Nothing Else Goes 
Blow Your Mind and Remain Where Nothing Else Goes 
Bleed Your Heart to the Day Where Nothing Else Goes 
Standing Still in the Parade 
Where Nothing Else Goes On 

Quiz Question Now: 
When Reality Ends 
Where do You Want to Be When You Start Dreaming? 
I´m Driving Faster Still to the Place Where I Should Not Be 
And Stars Are All Over Me 

Fireworks Matching the Day Where Nothing Else Goes 
Blow Your Mind and Remain Where Nothing Else Goes 
Bleed Your Heart to the Day Where Nothing Else Goes 
Standing Still in the Parade 
Where Nothing Else Goes On ");

$t->analyze();
?>