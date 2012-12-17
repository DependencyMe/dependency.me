Fonctionnalité: Connaître l'état des dépendances d'un paquet
  En tant que visiteur
  Afin de savoir si le paquet utilise des dépendances dépréciées
  Je dois pouvoir connaitre l'état des dépendances d'un paquet

  Contexte:
    Etant donné que je suis un visiteur
    Et que le paquet "myCoolPackage" a les dépendances suivantes:
      | dependance          | required      | latest    |
      | kikou-lol           | >1.0          | 1.5       |
      | my-beautiful-cat    | 3.6.7         | 3.8       |
      | evil-framewok       | 2.*           | 3         |

  Scénario: Connaître les dépendances d'un paquet
    Quand je souhaite connaître la liste des dépendances du paquet "myCoolPackage"
    Alors je peux savoir que le paquet "myCoolPackage" a les dépendances suivantes :
      | dependance        | version   |
      | kikou-lol         | >1.0      |
      | my-beautiful-cat  | 3.6.7     |
      | evil-framewok     | 2.*       |

  Plan de Scénario: Connaître l'état des dépendances d'un paquet
    Quand je souhaite connaître la liste des dépendances du paquet "myCoolPackage"
    Alors je peux savoir que la dépendance "<dependance>" est "<state>"

    Examples:
      | dependance        | state       |
      | kikou-lol         | latest      |
      | my-beautiful-cat  | recent      |
      | evil-framewok     | outofdate   |

