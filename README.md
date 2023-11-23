# Grix – ein Bootstrap-Sitebuilder für Contao


Grix vereinfacht die Erstellung und Bearbeitung von grid-basierten Seiteninhalten in Contao.


## Vorteile
* Inhaltselemente werden auch im Backend in der Grid-Ansicht angezeigt
* Inhaltselemente können per Drag&Drop in Spalten und Reihen arrangiert werden
* Die Bootstrap-Eigenschaften einer Spalte können mit wenigen Klicks geändert werden
* Schneller Vorschau-Wechsel zwischen den Breakpoints im Backend
* Reihen und Spalten können einfach ineinander verschachtelt werden
* Bereits erstellte Inhaltselemente können in eine Spalte importiert werden


![screen1](https://user-images.githubusercontent.com/4385048/103889062-1336f100-50e6-11eb-8844-925954f57a4e.png)
*Grix im Bearbeitungsmodus*

![screen2](https://user-images.githubusercontent.com/4385048/103889097-23e76700-50e6-11eb-9dbd-29688838b3d2.png)
*Grix im Vorschaumodus*

## Verwendung
Um den Grix-Sitebuilder bei der Bearbeitung eines Artikels zu verwenden, muss in den Artikel-Einstellungen die Checkbox "Grix aktivieren" angeklickt werden. Wurde das gemacht, ist das Grix-Bearbeitungsicon in der Artikel-Listenansicht aktiv (es ist nicht mehr ausgegraut). Der Artikel kann nun mit Grix bearbeitet werden. 

Wird Grix in den in den Artikel-Einstellungen wieder deaktiviert, werden die Inhaltselemente des Artikels wie zuvor ausgegeben.

Um die mit dem Bundle mitgelieferte Bootstrap-CSS-Datei zu verwenden, muss in den Layouteinstellungen die Checkbox "Grix CSS-Dateien laden" aktiviert werden.


## Den Grid bearbeiten

### Eigenschaften von Reihen, Spalten und Inhaltselementen ändern
Um die Eigenschaften von Reihen, Spalten und Inhaltselementen zu ändern, muss das Element zuerst ausgewählt werden. Klicke dazu in den leeren Bereich des jeweiligen Elements. Ist das Element ausgewählt, erscheint es mit einer orangen Umrandung. Wird beim Auswählen die Taste "Shift" gedrückt, können auch mehrere Elemente gleichzeitig ausgewählt bzw. bearbeitet werden.

Wurde die Auswahl gemacht, können im Header-Menü die Eigenschaften der Auswahl verändert werden. Durch einen Klick auf das Label des Buttons, kann eine definierte Eigenschaft auch wieder aufgehoben werden. Durch einen Klick auf "Kopieren" kann das ausgewählte Element (mit all seinen Inhalten) auch kopiert werden. Mit einem Klick auf den Button "Aufheben" wird die Auswahl wieder aufgehoben.

### Eigenschaften einer Reihe ändern
Wurde eine Reihe (oder mehrere) ausgewählt, kann der Abstand unterhalb (margin-bottom in rem) erhöht oder verringert werden.
Die Eigenschaften "Breite", "Versatz", "Push" und "Pull" sind für Reihen nicht verfügbar – diese Buttons sind daher ausgegraut.

### Eigenschaften einer Spalte ändern
Wurde eine Spalte (oder mehrere) ausgewählt, können  mit den Plus/Minus-Buttons die Eigenschaften "Breite", "Versatz", "Push" und "Pull" geändert werden. Zusätzlich kann die Spalte mit all ihren Inhaltselementen kopiert werden. Der Abstand unterhalb kann bei einer Spalte nicht verändert werden.

### Eigenschaften eines Inhaltselements ändern
Wurde ein Inhaltselement (oder mehrere) ausgewählt, kann der Abstand unterhalb (margin-bottom in rem) erhöht oder verringert werden.
Die Eigenschaften "Breite", "Versatz", "Push" und "Pull" sind für Inhaltselemente nicht verfügbar – diese Buttons sind daher ausgegraut.

### Den Reihen und Spalten CSS-Klassen zuweisen
Mit Grix wird ein Backendmodul namens "Grix CSS" mitinstalliert. Dieses Modul scheint im Backend in der vertikalen Seitenleiste (Gruppe "Layout") auf. Mit diesem Modul können CSS-Stile angelegt werden. Diese CSS-Stile können dann den Reihen und Spalten des Grids zugewiesen werden. Die Zuweisung erfolgt über das Zahnrad-Icon der Reihen und Spalten. Klickt man dieses Icon an, öffnet sich ein PopUp. Im oberen Bereich des PopUps können nun die zuvor angelegten CSS-Stile ausgewählt werden. Ist ein CSS-Stil aktiviert, erscheint er farblich hervorgehoben.

### Inhaltselemente per Drag&Drop arrangieren
Inhaltselemente können per Drag&Drop neu platziert werden. Dazu das Inhaltselement mit gedrückter Maustaste an den Zielort verschieben. Ein grüner Platzhalterrahmen zeigt an wenn das Inhaltselement eingefügt werden kann.

### Ausgabe-Breiten (Breakpoints) berücksichtigen
Die Änderungen an Reihen, Spalten und Inhaltselementen gelten für die unter "Ausgabegerät" aktivierte Ausgabe-Breite. 
Vier Ausgabe-Breiten (Breakpoints) stehen zur Verfügung:
* Extra small devices (< 768px)
* Small devices (≥ 768px)
* Medium devices (≥ 992px)
* Large devices (≥ 1200px)

Werte werden dabei an höhere Ausgabe-Breiten "vererbt". D.h. eine Änderung für "Extra small devices" gilt auch für die höheren Ausgabe-Breiten. Es sei denn bei diesen Ausgabe-Breiten werden eigene Werte definiert.


## Die Bearbeitungs-Menüs 
Reihen, Spalten und Inhaltselementen enthalten jeweils Bearbeitungs-Menüs. Diese erscheinen unterhalb des Elements und sind grau hinterlegt. Die Funktionen in diesen Menüs sind je nach Element verschieden. 

### Das Reihen-Bearbeitungs-Menü
Das Reihen-Bearbeitungs-Menü enthält folgende Funktionen (von links nach rechts):
* Der Reihe eine weitere Spalte hinzufügen
* Eine weitere Reihe unterhalb der jeweiligen Reihe einfügen
* Vordefinierte Spaltenkonfiguration für die Ausgabe-Breiten in einer Übersicht definieren
* Vordefinierte Spaltenkonfiguration anwenden
* Die Reihe nach oben oder unten verschieben
* Die Reihe entfernen

### Das Spalten-Bearbeitungs-Menü
Das Spalten-Bearbeitungs-Menü enthält folgende Funktionen (von links nach rechts):
* Innerhalb der Spalte eine Reihe einfügen (Reihen und Spalten können beliebig verschachtelt werden)
* Ein neues Inhaltselement in die Spalte einfügen
* Ein bereits in diesem Artikel erstelltes Inhaltselement in die Spalte importieren
* Die Spalte entfernen

### Das Inhaltselement-Bearbeitungs-Menü
Das Inhaltselement-Bearbeitungs-Menü enthält folgende Funktionen (von links nach rechts):
* Das Inhaltselement bearbeiten
* Ein neues Inhaltselement unterhalb des jew. Inhaltselement einfügen
* Das Inhaltselement entfernen (es wird nur aus dem Grid entfernt, nicht tatsächlich gelöscht)


## Vorschau aktivieren
Durch einen Klick auf den Button "Vorschau" werden die UI-Elemente des Grids ausgeblendet. Zusätzlich werden die Inhaltselmente ohne Maximal-Breite angezeigt. So bekommt man einen besseren Eindruck wie der Grid im Frontend aussehen wird. Ein Arrangieren mit Drag-and-Drop ist auch im Vorschau-Modus möglich.