-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 04 dec 2024 om 12:23
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `author_name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `authors`
--

INSERT INTO `authors` (`id`, `author_name`) VALUES
(1, 'Leigh Bardugo'),
(2, 'Talia Hibbert'),
(3, 'Gijs Haag'),
(4, 'Veronica Roth'),
(5, 'Marjon Hoffman'),
(6, 'Rebecca Yarros'),
(7, 'Elena Armas'),
(8, 'Stephenie Meyer'),
(9, 'Thorsten Saleina'),
(10, 'Marcus Pfister'),
(11, 'Dick Bruna'),
(12, 'Rutger Van Den Broeck en Mark Haayema'),
(13, 'Plantyn'),
(14, 'Prisma'),
(15, 'Van In '),
(16, 'James Dashner'),
(17, 'Ernest Cline'),
(18, 'Suzanne Collins'),
(19, 'Julia Quinn'),
(20, 'Richelle Mead'),
(21, 'Eva Schot'),
(22, 'Patrick van Rijn'),
(23, 'Jet Boeke'),
(24, 'Jon Duckett'),
(25, 'J.R.R. Tolkien (John Ronald Reuel Tolkien)'),
(26, 'Stephanie Garber'),
(27, 'Mylo Freeman'),
(28, 'John Flanagan'),
(29, 'Sarah J Maas'),
(30, 'Martin Scharenborg'),
(31, 'Elisabetta Dami'),
(34, 'Auteur naam');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `username` varchar(300) NOT NULL,
  `email` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usertype` int(11) DEFAULT 0,
  `credits` float DEFAULT 1000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `clients`
--

INSERT INTO `clients` (`id`, `username`, `email`, `password`, `usertype`, `credits`) VALUES
(1, '', 'hey@email.com', '$2y$15$n.8TR3.TcC0G96MLPxlxU.koK7YXZkKFhZq42uvr7PlhPsU/5UdjW', 0, 1000),
(13, '', 'Blossom@email.com', '$2y$15$qjmeGt8rpYhpyvjTDyjN2egGEEgZHJk9sIfVw2DmHqCNlCo.btAlG', 0, 1000),
(89, 'Audrey', 'admin@email.com', '$2y$10$DPjOaSIAW3gICFwfPBL0COawJpdcKa0/LBYXBaSDkrlp71/tb4gH2', 1, 0),
(92, 'Lily', 'lily@email.com', '$2y$10$wSg/RhaA/S5QB6Lwku5EvuhZEu/XhSKN.jDjZBJNQAZpnkBI4K7fW', 0, 1000);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `genres`
--

INSERT INTO `genres` (`id`, `genre_name`) VALUES
(1, 'Romantiek'),
(2, 'Fantasie'),
(3, 'Kinder- en jeugdliteratuur'),
(4, 'Studieboeken'),
(5, 'Komedie'),
(6, 'Sci-Fi');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `product_description` varchar(600) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `product_price` decimal(11,2) NOT NULL,
  `product_img` varchar(500) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `genre_id`, `product_price`, `product_img`, `author_id`) VALUES
(1, 'Shadow and Bone', 'Alina Starkov is nooit ergens goed in geweest. Maar als haar regiment wordt aangevallen en haar beste vriend Mal zwaargewond raakt, ontwaakt er bij Alina een onbekende kracht die zijn leven redt. Een kracht die het door oorlog getergde koninkrijk voor eens en altijd kan bevrijden. Alina moet alles achterlaten om haar training te starten onder het wakende oog van De Duisterling. Maar is haar gave het enige waar hij oog voor heeft? ', 2, 10.99, 'img/shadowandbone.jpg', 1),
(2, 'Get a Life, Chloe Brown', 'Chloë is niet de average hoofdpersonage in een romance: ze is chronisch ziek, een computernerd en ze was bijna dood. Die gebeurtenis zet haar aan tot het opstellen van een lijst vol buitenissigheden, zoals dronken worden, motorrijden én iets slechts doen. Enter Redford Morgan, een hele aantrekkelijke klusjesman met tattoos en een motor. De perfecte persoon voor haar lijstje mee af te werken. hallo', 1, 15.99, 'img/getalifechloebrown.jpg', 2),
(3, 'Tiny en De Verassing ', 'Tiny’s nichtje Ellie komt op bezoek. De meisjes hebben elkaar lange tijd niet meer gezien. Tiny heeft een mooie verrassing voor Ellie!\r\n\r\nDe avonturen van Tiny gaan al heel veel jaren mee en blijven nog altijd een plezier om te lezen.\r\n', 3, 5.99, 'img/tinyendeverassing.jpg', 3),
(5, 'Divergent 1', 'Futuristisch Chicago. De wereld van de zestienjarige Tris is opgedeeld in vijf facties: Oprechtheid, Zelfverloochening, Onverschrokkenheid, Vriendschap en Eruditie. Ieder jaar moeten alle zestienjarigen kiezen bij welke factie zij de rest van hun leven willen horen. Voor Beatrice betekent dit dat ze een keus moet maken tussen haar familie en haar ware identiteit. Haar beslissing verrast iedereen, vooral haarzelf.', 2, 25.50, 'img/divergent.jpg', 4),
(6, 'Floor is smoor', 'Floor is smoorverliefd op een jongen, maar ze weet helemaal niet hoe hij heet. Haar beste vriendin Margreet heeft het ook zwaar te pakken, maar dan niet van een jongen, maar van een paard. En met Valentijnsdag gooien Floor en Margreet bij alle jongens uit de buurt een kaart in de bus. Ze zijn alleen maar één ding vergeten...', 3, 15.99, 'img/floorIsSmoor.jpg', 5),
(7, 'Fourth Wing 1 - In Steen Gebrand', 'In steen gebrand is het eerste deel van de populaire fantasyserie Fourth Wing, die gaat over Violet. Haar droom om scribent te worden aan het befaamde Basgiath Oorlogscollege valt in duigen wanneer de generaal - oftewel haar moeder – haar opdraagt deel te nemen aan het selectieproces van de Drakenrijders. De helft van de cadetten zal het eerste jaar niet overleven en de meesten willen Violet vanwege haar afkomst uit de weg ruimen, vooral de knappe Xaden.', 2, 29.99, 'img/fourth wing.jpg', 6),
(8, 'The American Roommate Experiment', 'Rosie Graham has a problem. A few, actually. She just quit her well paid job to focus on her secret career as a romance writer. She hasn’t told her family and now has terrible writer’s block. Then, the ceiling of her New York apartment literally crumbles on her. Luckily she has her best friend Lina’s spare key while she’s out of town. But Rosie doesn’t know that Lina has already lent her apartment to her cousin Lucas, who Rosie has been stalking—for lack of a better word—on Instagram for the last few months. Lucas seems intent on coming to her rescue like a Spanish knight in shining armour.', 1, 10.99, 'img/theAmericanRoommateExperiment.jpg', 7),
(9, 'The Spanish Love Deception', 'Catalina Martín desperately needs a date to wedding of her sister. Especially when her little white lie about her American boyfriend has spiralled out of control. Now everyone she knows – including her ex-boyfriend and his fiancée – will be there. She only has four weeks to find someone willing to cross the Atlantic for her and aid in her deception. NYC to Spain is no short flight and her family won&amp;#039;t be easy to fool. But even then, when Aaron Blackford offers to step in, she&amp;#039;s not tempted even for a second. Never has there been a more aggravating, blood-boiling and insuffera', 1, 8.99, 'img/theSpanischLoveDeception.jpg', 7),
(10, 'Twillight ', 'Als Bella Swan naar het regenachtige Forks verhuist en de mysterieuze en aantrekkelijke Edward Cullen ontmoet, neemt haar leven een spannende wending.\r\nEdward, met zijn krijtwitte huid, gouden ogen en betoverende stem, is zowel onweerstaanbaar als ongenaakbaar. Tot nu toe heeft hij zijn ware identiteit verborgen weten te houden, maar Bella is vastbesloten achter zijn geheim te komen. Wat Bella zich niet realiseert, is dat ze haar leven en dat van anderen in gevaar brengt naarmate ze hem beter leert kennen.\r\nEn misschien is het al te laat...', 1, 22.99, 'img/twillight.jpg', 8),
(26, 'Van wie zijn deze billen?', 'Van wie zijn deze billen? Een boekje om te raden en te lachen! De vrolijke rijmpjes stimuleren kinderen om mee te raden en te ontdekken wat er achter de grote, stevige flapjes te zien is. Dit speelboekje is leuk voor jong en oud!', 3, 10.99, 'img/vanwie.jpg', 9),
(27, 'De mooiste vis van de zee!', 'Regenboog is de mooiste vis in de zee. Maar hij is trots en ijdel, en daardoor heeft hij geen enkele vriend. Pas als hij een van zijn mooie schubben weggeeft - en later nog meer - vinden ze hem aardig en merkt hij dat het belangrijker is om vrienden te hebben dan om de mooiste te zijn!', 3, 5.99, 'img/mooistevis.jpg', 10),
(28, 'Met Nijntje naar bed - flapjesboek', 'Het is bijna bedtijd voor nijntje. Wat doet ze voor het slapengaan? Eten, pyjama aan, tandenpoetsen en een boekje lezen. En dan: lekker slapen. Droom maar fijn, nijntje! Een vrolijk boek om je kind voor te bereiden op bedtijd; ook nijntje heeft een ritueel voor ze naar bed gaat. Kijk je mee? Op elke spread zit een makkelijk te openen flap, waardoor jonge lezertjes zelf de flapjes kunnen openmaken.', 3, 8.95, 'img/nijntje.jpg', 11),
(29, '‘t Verukkelijke Kinderbakboek ', 'De familie Bakker is het liefst de hele dag in de weer met bloem, eieren, boter en suiker. Het hele jaar door maken ze de lekkerste baksels: cheesecakejes met aardbeien in de lente, strandkoekjes in de zomer, rozijnenbollen in de herfst, en ’s winters natuurlijk kruidnoten en kerstkransjes. En wat te denken van de honnepon, een ratjetoe of verwentelteefjes? ’t Verrukkelijke kinderbakboek is het leukste bakboek voor kinderen vanaf zes jaar!', 3, 24.99, 'img/kinderbakboek.jpg', 12),
(30, 'Wiskanjers 1: Werkboek ', 'De Wiskanjers Maak van elk kind een ware wiskundekampioen! Wiskundemethodes voor het eerste leerjaar. \r\n', 4, 7.50, 'img/wiskanjers1.jpg', 13),
(31, 'Wiskanjers 2: Werkboek ', 'De Wiskanjers Maak van elk kind een ware wiskundekampioen! Wiskundemethodes voor het tweede leerjaar. \r\n', 4, 7.50, 'img/wiskanjers2.jpg', 13),
(32, 'Prisma woordenboek Nederlands', 'Al ruim 50 jaar worden de Prisma woordenboeken samengesteld, bijgewerkt en gecontroleerd door een team van ervaren lexicografen. Ook deze editie is van A tot Z up-to-date, betrouwbaar, overzichtelijk en voordelig. Dit woordenboek biedt een schat aan taalinformatie voor leerlingen in het hele secundaire onderwijs in België, met heldere definities en voorbeelden hoe je het trefwoord in een zin gebruikt. Ook vind je er de verklaringen van veel spreekwoorden en uitdrukkingen in, plus natuurlijk alles wat je wilt weten over uitspraak en grammatica, zoals vervoegingen en lidwoorden.', 4, 10.50, 'img/prisma.jpg', 14),
(33, 'Talent 3 - Spelling', 'Het spellingschrift leert de leerlingen de spellingvaardigheden aan en biedt volop kansen om die vaardigheden verder te oefenen. In dit spellingschrift vind je de spellinglessen van thema 1-3, met achteraan de spellingweters.', 4, 3.50, 'img/spelling3.png', 15),
(34, 'Talent 4 - Spelling', 'Het spellingschrift leert de leerlingen de spellingvaardigheden aan en biedt volop kansen om die vaardigheden verder te oefenen. In dit spellingschrift vind je de spellinglessen van thema 1-3, met achteraan de spellingweters.', 4, 3.50, 'img/spellings4.png', 15),
(35, 'Woordpakket 5: Tijd voor Taal Spelling', 'Scheurblok voor kinderen met leerproblemen, met oefeningen voor de wekelijkse remediëring en verrijking. Geschikt voor studenten vanaf het 5de leerjaar. ', 4, 9.99, 'img/woordpakket5.png', 15),
(36, 'Woordpakket 6: Tijd voor Taal', 'Scheurblok voor kinderen met leerproblemen, met oefeningen voor de wekelijkse remediëring en verrijking. Geschikt voor studenten vanaf het 6de leerjaar. ', 4, 9.99, 'img/woordpakket6.png', 15),
(37, 'The Maze Runner', 'When Thomas arrives in the Glade, a walled encampment at the centre of a bizarre maze, all he remembers is his first name. But he is not alone. Like Thomas, the Gladers do not know why they are there, or what has happened to the world outside. All they know is that every morning when the walls slide back, they will risk everything to find out.', 6, 12.99, 'img/mazerunner.jpg', 16),
(38, 'Ready Player One', 'Het is het jaar 2044 en de bestaande wereld is een afschuwelijke plek geworden. Er is geen olie meer. We hebben het klimaat verwoest. Er is overal sprake van hongersnood, armoede en ziektes. Net als de meeste mensen ontsnapt Wade aan deze deprimerende wereld door zijn tijd te spenderen in OASIS, een uitgebreide virtuele utopie waar je alles kan zijn wat je maar wil zijn, waar je kan leven en spelen en verliefd kan worden op een van de tienduizenden planeten. En net als de meeste mensen is Wade geobsedeerd door het ultieme lot uit de loterij dat verborgen ligt in deze alternatieve wereld: De op', 6, 8.95, 'img/readyplayer1.jpg', 17),
(39, 'Six of Crows', 'Criminal prodigy Kaz Brekker is offered a chance at a deadly heist that could make him rich beyond his wildest dreams - but he cannot pull it off alone. A convict with a thirst for revenge, a sharpshooter who cannot walk away from a wager, a runaway with a privileged past, a spy known as the Wraith, a Heartrender using her magic to survive the slums and a thief with a gift for unlikely escapes. Six dangerous outcasts. One impossible heist.', 2, 8.99, 'img/sixofcrows.jpg', 1),
(40, 'The Hunger Games 1', 'First in the ground-breaking HUNGER GAMES trilogy. In a vision of the near future, a terrifying reality TV show is taking place. Twelve boys and twelve girls are forced to appear in a live event called The Hunger Games. There is only one rule: kill or be killed. But Katniss has been close to death before. For her, survival is second nature.', 2, 11.50, 'img/hungergames.jpg', 18),
(41, 'Brigerton 1: De ongetrouwde hertog', 'Daphne Bridgerton heeft geleerd dat ze maar één doel heeft in het leven: het vinden van een geschikte huwelijkskandidaat. Als de anonieme roddelaarster Lady Whistledown haar afdoet als oud nieuws, lijkt dat desastreus voor Daphnes kansen. Tot de aantrekkelijke hertog Simon Basset in haar leven komt. Simon wordt gek van alle gretige moeders die hem hun huwbare dochters opdringen, en besluit het op een akkoordje te gooien met Daphne. Ze doen net alsof ze verloofd zijn: zo redt Daphne haar reputatie en krijgt Simon wat rust.', 1, 12.99, 'img/bridgerton1.jpg', 19),
(42, 'Bridgerton 2 - De verliefde graaf', 'Anthony Bridgerton maakt volgens Lady Whistledown nog geen aanstalten om zich te verloven. Maar dit keer zit het roddelblad ernaast. Anthony heeft niet alleen besloten te trouwen, hij weet zelfs al met wie! Het enige obstakel is zijn aanstaande schoonzus, Kate Sheffield, de meest bemoeizieke vrouw die zich ooit in een Londense balzaal heeft gewaagd.Wat de societydames ook mogen zeggen, Kate is ervan overtuigd dat Anthony een verschrikkelijke echtgenoot zal zijn. Ze is vastbesloten om haar zus te beschermen. Maar hoe beschermt ze haar eigen hart tegen de invloed van deze verleidelijke graaf?', 1, 12.99, 'img/bridgerton2.jpg', 19),
(43, 'Vampire Academy Boxset 1 tot 6', 'Deze boxset bevat alle zes volumes uit de Vampire Academy serie: 1 Vampire Academy, 2 Frostbite, 3 Shadow Kiss, 4 Blood Promise, 5 Spirit Bound, 6 Last Sacrifice', 1, 44.50, 'img/vampireacademy.jpg', 20),
(44, 'De Zoete Zusjes - De stoute broertjes moppenboek', 'De Zoete Zusjes en hun moeder Hanneke de Zoete hebben wat afgelachen in hun eerste twee moppenboeken. Maar hun nieuwe buurjongens Daan en Mees denken dat ze de meiden nog wel wat kunnen leren over een goeie grap. Ze noemen zichzelf niet voor niks: de Stoute Broertjes. In dit moppenboek voor jongens én meisjes hebben zij de leukste moppen, raadsels, grappen en pranks verzameld. Vertel ze aan je vriendjes, klasgenootjes of je oma en opa en laat iedereen lekker lachen, gieren, brullen!', 5, 11.99, 'img/dezoetezusjes.jpg', 21),
(45, 'Het superdikke Mr. Bean moppenboek', 'Ben jij de leukste thuis? Dan kun je het superdikke Mr. Bean moppenboek echt niet laten liggen! Je blijft lachen, gieren, brullen met dit superleuke moppenboek van Mr. Bean. Moppenboeken zijn razend populair bij kinderen vanaf 6 jaar.', 5, 10.99, 'img/mrbean.jpg', 22),
(46, 'Dikkie Dik wacht op Sinterklaas', 'In het kartonnen flapjesboek Dikkie Dik wacht op Sinterklaas wil Dikkie Dik nog lang niet slapen. Want wat als hij precies slaapt als Sinterklaas langskomt? Hij wacht dus vol verwachting of hij de hoeven het paard van Sinterklaas al hoort op het dak, maar telkens als hij denkt hem te horen, is het een ander dier. En daar wordt Dikkie Dik zo slaperig van...', 3, 11.99, 'img/dikkiedik.jpg', 23),
(47, 'Html and CSS Design', 'Leer HTML en CSS uit het boek dat honderdduizenden codeerders van beginners tot gevorderden heeft geïnspireerd. Professionele webontwerpers, ontwikkelaars en programmeurs, maar ook nieuwe studenten, willen hun webontwerpvaardigheden op het werk vergroten en hun persoonlijke ontwikkeling uitbreiden, maar het online vinden van de juiste bronnen kan overweldigend zijn. Zet een zelfverzekerde stap in de goede richting door te kiezen voor de eenvoud van HTML and CSS: Ontwerp en bouw websites door de ervaren webontwikkelaar en programmeur Jon Duckett.', 4, 15.99, 'img/htmlcss.jpg', 24),
(48, 'JavaScript and Jquery', 'Dit kleurenboek hanteert een visuele benadering van het aanleren van JavaScript en jQuery en laat zien hoe u webpaginas interactiever en interfaces intuïtiever kunt maken door het gebruik van inspirerende codevoorbeelden, infographics en fotografie. De inhoud veronderstelt geen eerdere programmeerervaring, behalve dat je weet hoe je een eenvoudige webpagina in HTML en CSS maakt. Je leert technieken toepassen die je op veel populaire websites tegenkomt (zoals het toevoegen van animaties, panelen met tabbladen, schuifregelaars voor inhoud, formuliervalidatie, interactieve galerijen en het ', 4, 16.99, 'img/javascriptjquery.jpg', 24),
(49, 'PHP and MySQL', 'PHP draait op webservers en stelt websites in staat paginas voor elke individuele bezoeker aan te passen met behulp van inhoud die is opgeslagen in een MySQL-database. De eenvoudige, visuele uitleg en hapklare codevoorbeelden in dit boek maken het gemakkelijk voor u om websites te ontwikkelen met behulp van PHP en MySQL waarmee bezoekers zich als lid kunnen registreren, artikelen kunnen maken en bewerken, afbeeldingen kunnen uploaden, profielen kunnen beheren, commentaar kunnen geven op of likes, berichten posten, en meer...\r\n', 4, 18.99, 'img/phpmysql.jpg', 24),
(50, 'Fourth Wing 2: Iron Flame', 'Tegen alle verwachtingen in heeft Violet Sorrengail haar eerste jaar op het Basgiath War College doorstaan, maar nu begint de echte training. De inzet is hoger dan ooit en de vastberadenheid om te overleven zal deze keer niet genoeg zijn. Wanneer een krachtige nieuwe vijand alles waar ze om geeft bedreigt, inclusief de man van wie ze houdt, moet Violet alles doen wat nodig is om hun geheimen veilig te houden. Eén verkeerde beweging kan gruwelijke gevolgen hebben. En als het web van leugens zich begint te ontrafelen, kan niets genoeg zijn om hen uiteindelijk te redden.', 2, 30.99, 'img/ironflame.jpg', 6),
(51, 'Lord of the Rings boxset', 'Deze driedelige boxset van Tolkiens epische meesterwerk, Lord of the Rings, vervolgt het verhaal van de Hobbit en beschikt over opvallende zwarte omslagen gebaseerd op Tolkiens eigen ontwerp, de definitieve tekst en drie kaarten, waaronder een gedetailleerde kaart van Midden-aarde. Sauron, de Heer van het Duister, heeft alle Rings of Power bij zich verzameld: de middelen waarmee hij Midden-aarde wil regeren. Het enige wat hij mist in zijn plannen voor heerschappij is de Ene Ring – de ring die ze allemaal regeert – die in handen is gevallen van de hobbit, Bilbo Baggins.', 2, 26.50, 'img/lordoftherings.jpg', 25),
(52, 'Carnaval', 'De zussen Scarlett en Donatella ontvluchten uit angst voor hun wrede vader het kleine, afgelegen eiland waar ze wonen. Ze worden daarbij geholpen door de o zo verleidelijke maar onuitstaanbare Julian. Ze komen terecht op Dromeneiland, waar de jaarlijkse voorstelling van Caraval wordt gehouden. Het publiek speelt mee in een dodelijk spel en moet achterhalen wat fantasie is en wat echt. Vlak na aankomst op het eiland verdwijnt Donatella, en Scarlett kan maar aan één ding denken: haar zus terugvinden voor de boosaardige meester van Caraval haar vindt en er doden vallen.', 1, 17.50, 'img/carnaval.jpg', 26),
(53, 'Maxime en Sophie - De grootste challenge ooit', 'Een spetterend boek over het leukste meidenduo van TikTok en YouTube! De ouders van Maxime zijn een weekendje weg. Nu kan zij met Sophie eindelijk een vette Waterslide Challenge in hun tuin opnemen. Beter nog: ze veranderen het hele huis in een zwemparadijs! Maar Maximes kleine broertje Gideon wil alles verraden aan Maximes moeder. Er is heel veel paprikachips nodig om hem tegen te houden. En er is heel weinig tijd om de challenge op te nemen én alles weer op te ruimen... Een hilarisch avontuur met glansrollen voor de beroemde typetjes van Maxime &amp;amp;amp;amp;amp; Sophie. Met veel striptek', 3, 15.99, 'img/maxensophie.jpg', 27),
(54, 'De Grijze Jager 1 - De ruïnes van Gorlan', 'De ruïnes van Gorlan gaat over Will. Will is klein voor zijn leeftijd, maar razendsnel en niet dom. Zijn hele leven heeft hij ervan gedroomd om ridder te worden, net als zijn vader, die hij nooit heeft gekend. Hij is dan ook hevig teleurgesteld als hij afgewezen wordt voor de krijgsschool van kasteel Redmont. In plaats daarvan wordt hij toegewezen aan Halt, de mysterieuze Grijze Jager wiens grootste talent lijkt te zijn dat hij zich onopvallend door het rijk kan verplaatsen.', 2, 12.99, 'img/grijzejager.jpg', 28),
(55, 'De Glazen Troon', 'Celaena wordt voor de keuze gesteld: óf haar leven slijten in de gevangenis, óf deelnemen aan een toernooi waarvan de winnaar de nieuwe kampioen van de koning wordt. Een voor een worden de deelnemers van het toernooi echter op gruwelijke wijze vermoord en al snel vecht Celaena niet alleen voor haar vrijheid, maar ook voor haar leven.', 2, 5.99, 'img/glazentroon.jpg', 29),
(56, 'Onderzoeken van fraude', 'De schrijver heeft zich de accountancy, het ondernemings-, fiscaal- en strafrecht meester gemaakt. Hij publiceert op het gebied van strafrecht, integriteit en fraude. Dit boek biedt de lezer een handvat hoe fraude onderzocht kan worden. Hierbij wordt ingegaan op de opsporingsambtenaar, de particulier onderzoeker, de forensisch IT-auditor en de forensisch accountant. Daarnaast worden veertien modelonderzoeken beschreven hoe fraude onderzocht zou kunnen worden. Het boek biedt de onderzoeker van fraude ondersteuning, maar ook de opdrachtgever en degene die onderzocht wordt.', 4, 25.99, 'img/onderzoekfraude.jpg', 30);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT voor een tabel `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT voor een tabel `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
