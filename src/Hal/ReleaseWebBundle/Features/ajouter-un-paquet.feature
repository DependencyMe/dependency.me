Fonctionnalité: Ajouter un paquet
  En tant que propriétaire d'un paquet
  Afin de permettre à tous de savoir si j'utilise des librairies à jour
  Je dois pouvoir ajouter mes paquets

  Contexte:
    Etant donné que je suis un propriétaire de paquet enregistré

  Scénario: Ajouter un paquet
    Quand je souhaite ajouter le paquet "myCoolPackage" dont les sources sont disponibles à l'adresse "file//.....git"
    Alors je peux constater que le paquet "myCoolPackage" a été ajouté

  Scénario: Ajouter un paquet indisponible
    Quand je souhaite ajouter le paquet "myCoolPackage" dont les sources sont indisponibles
    Alors on me notifie que les sources du paquet "myCoolPackage" sont indisponibles
    Et je peux constater que le paquet "myCoolPackage' n'a pas été ajouté
