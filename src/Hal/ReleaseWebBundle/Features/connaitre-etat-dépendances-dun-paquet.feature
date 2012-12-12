Fonctionnalité: Connaître l'état des dépendances d'un paquet
  En tant que visiteur
  Afin de savoir si le paquet utilise des dépendances dépréciées
  Je dois pouvoir connaitre l'état des dépendances d'un paquet

  Contexte:
    Etant donné que je suis un visiteur
    Et que le paquet "monPaquet1" a les dépendances suivantes:
      """
      {"require":{
        "symfony-framework": "2.1.0",
        "doctrine/orm": ">=2.2.3",
        "sensio/generator-bundle": "<2"
      }}
      """

  Scénario: Connaître les dépendances d'un paquet
    Quand je souhaite connaître la liste des dépendances du paquet "monPaquet1"
    Alors je peux savoir que le paquet "monPaquet1" a les dépendances suivantes :
      | dépendance              | version   |
      | symfony-framework       | 2.1.0     |
      | doctrine/orm            | >=2.2.3   |
      | sensio/generator-bundle | 2.1.*     |

  Plan de Scénario: Connaître l'état des dépendances d'un paquet
    Quand je souhaite connaître la liste des dépendances du paquet "monPaquet1"
    Alors je peux savoir que la dépendance "<dependance>" est "<state>"

    Examples:
      | dependance              | state       |
      | symfony-framework       | recent      |
      | doctrine/orm            | latest      |
      | sensio/generator-bundle | outofdate   |

