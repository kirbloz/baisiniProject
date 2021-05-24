*/* baisiniProject */*

## SITO WEB - PROGETTO D'ELABORATO

   Simulazione del sito web di un azienda un’azienda che si occupa dell’installazione di reti LAN e WLAN, solitamente scuole ed uffici. Il sito web avrà dei link cliccabili che permetteranno il download di documenti in inglese dedicati a proxy e DMZ (lavoro CLIL).
   Funzionalità di Login e Signup, con interfacciamento ad un DB creato e gestito da MySQL Workbench.

---

### Descrizione

Il sito web sarà hostato da Altervista, integrato di DB sviluppato con MySQL Workbench e gestito tramite phpMyAdmin dal lato server. Ci sarà l’ausilio di GitHub per la gestione dei file e del codice ma soprattutto lo storico delle modifiche.

### Contesto

L’impresa EasyLAN gestita da un’omonima società desidera creare un database per amministrare la sua attività ma anche mettere a disposizione un sito web per l’accesso dei clienti a certi servizi. 

In breve i servizi WEB a disposizione dei terzi sono:
<ul>
   <ol>registrazione e login per accedere all’area utente;</ol>
   <ol>invio ticket per l'assistenza;</ol>
   <ol>possibilità di visualizzare le richieste di assistenza, e gli interventi/installazioni richiesti dai clienti in sede fisica, telefonica o via email;</ol>
</ul>

---

#### Dettagli tecnici

**Gestione degli utenti:** la gestione degli utenti avviene tramite memorizzazione nel database di tuple che contengono username, email e password. La password viene salvata come hash prodotto dalla funzione PHP password_hash() che utilizza l’algoritmo BCRYPT. C’è a disposizione dell’utente la possibilità di registrare ulteriori informazioni – utili poi per la prenotazione di interventi – tramite la registrazione dell’entità Customer, ovvero Cliente. 
Ogni Utente ha accesso alla pagina Area Utente, dove può visualizzare quali informazioni relative a sé stesso sono memorizzate nel database dell’azienda. È inoltre possibile cambiare la password al proprio user oppure eliminare il profilo – la tupla – dal database.
Nell’Area Utente è possibile usare dei bottoni appositi per navigare su altre pagine e visualizzare gli interventi richiesti (disponibile solo se abilitato, è richiesto avere un’entità Cliente legata al proprio Utente), i ticket di assistenza creati e il relativo stato ed infine richiedere un preventivo, generato automaticamente da uno script PHP.
Dal lato azienda la gestione degli utenti avviene rendendo disponibili più pagine web dedicate alla visualizzazione della tabella user unita a customer secondo l’id_user. È anche possibile selezionare ed eliminare delle tuple Utente se necessario.

**Gestione dei dipendenti:** nel contesto ipotizzato e più favorevole all’applicazione di questo sistema, l’azienda fornisce a ogni suo dipendente di un numero di Matricola (id_technician nel DB) e una password. È compito del tecnico (di grado almeno Capo Ufficio oppure Supervisore) inserire una tupla all’interno del database che rappresenti il dipendente appena assunto. Le informazioni salvate in questa tupla sono il nominativo, il genere, la data di nascita, la matricola del supervisore, l’identificativo dell’ufficio presso il quale lavora ed eventuale costo di manodopera.
In concomitanza alla tupla della tabella technician verrà memorizzata anche una tupla nella tabella superuser, contenente effettivamente la matricola del Tecnico come FK, l’indirizzo email fornito in sede di colloquio, l’hash della password generata dall’azienda ed infine il Power Level.
Il Power Level è un valore che può essere 0 – 1 – 2. 
0: il Tecnico relativo a questo Superutente è un Dipendente. Può accedere alla sua Area Utente e visualizzare gli interventi in cui risulta parte della manodopera.
1: il Tecnico relativo a questo Superutente è un Supervisore. La sua matricola apparirà nel campo id_supervisor dei Tecnici con Power Level uguale a uno. Il suo supervisore è sé stesso quindi un Supervisore avrà sempre id_supervisore e id_technician coincidenti. 
Può accedere alla sua Area Utente e visualizzare gli interventi in cui risulta parte della manodopera, ma può anche visualizzare la sua “Squadra” – tutti i Tecnici Dipendenti supervisionati da questa persona – con i relativi dati ed interventi. Ha inoltre accesso alla gestione degli user.
2: il Tecnico relativo a questo Superutente è un Capo Ufficio. La sua matricola può apparire in nessuno o più campi id_supervisor di diversi Tecnici con Power Level uguale a uno. La sua matricola appare nella tabella office sotto il nome di id_manager. È la persona che idealmente si occupa di dirigere i singoli uffici ed ha accesso alla gestione sia degli user che dei superuser. Ha accesso al gestionale per gli ordini: può cambiare lo stato di un pagamento, inserire nuovi ordini e consultare la disponibilità di componenti.

*/* Baisini Wade, 2021 */*
