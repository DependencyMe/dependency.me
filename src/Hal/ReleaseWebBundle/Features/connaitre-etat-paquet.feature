Fonctionnalité: Connaître l'état d'un paquet
  En tant que propriétaire d'un paquet
  Afin de permettre à tous de savoir si j'utilise des librairies à jour
  Je dois pouvoir connaître facilement l'état de mon paquet

  Contexte:
    Etant donné que je suis propriétaire du paquet "myCoolPackage"

  Plan de Scénario: Offrir un moyen visuel de connaître l'état d'un paquet
    Etant donné que le paquet "<paquet>" est "<etat>"
    Alors je peux visualiser une image qui indique "<image>"

    Exemples:
      | paquet           | etat      | image         |
      | myCoolPackage    | latest    | latest        |
      | myCoolPackage    | recent    | recent        |
      | myCoolPackage    | outofdate | outofdate     |
      | myCoolPackage    | unknown   | unknown       |