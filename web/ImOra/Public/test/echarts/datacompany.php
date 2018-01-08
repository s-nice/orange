<?php
$color = array('#b21111','#f39707','#006538');
$nodeType = array('user'=>'好友','company'=>'公司','card'=>'名片','search'=>'中心人物');
$linkType = array('Has'=>'名片','Work'=>'公司','Friend'=>'好友');
$legend = array('朋友','名片','公司');
$str = '{
  "results": [
    {
      "columns": [
        "q"
      ],
      "data": [
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14491,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "21023",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王喆",
                  "company": "北京橙鑫数据科技有限公司",
                  "title": "橙云测试部",
                  "userid": "AO9uRiVzxwPPxTlGTmS7onMch5iWg00000000797"
                }
              }
            ],
            "relationships": [
              {
                "id": "14491",
                "type": "Friend",
                "startNode": "13729",
                "endNode": "21023",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14498,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "11731",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "杜潜",
                  "company": "橙鑫",
                  "title": " 测试工程师",
                  "userid": "AXEeU08pona2csv4FvqBCiYF605Qf00000004366"
                }
              }
            ],
            "relationships": [
              {
                "id": "14498",
                "type": "Friend",
                "startNode": "13729",
                "endNode": "11731",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14487,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "15995",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "蔡蓉",
                  "company": "橙鑫数据",
                  "title": "软件测试",
                  "userid": "AB6K15DgluQ5OAmwRMNCO5B61lcUw00000000827"
                }
              }
            ],
            "relationships": [
              {
                "id": "14487",
                "type": "Friend",
                "startNode": "13729",
                "endNode": "15995",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 85552,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "69754",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "田建林PHP",
                  "company": "橙鑫数据科技有限公司",
                  "title": "",
                  "userid": "AYcjhx1QeKsVnxn41orehpKo7RrCr00000001196"
                }
              }
            ],
            "relationships": [
              {
                "id": "85552",
                "type": "Friend",
                "startNode": "69754",
                "endNode": "13729",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 16091,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "17018",
                "labels": [
                  "Company"
                ],
                "properties": {
                  "name": "公司名称农民战争"
                }
              }
            ],
            "relationships": [
              {
                "id": "16091",
                "type": "Work",
                "startNode": "13729",
                "endNode": "17018",
                "properties": {}
              }
            ]
          }
        },
		{
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 16091,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "17098",
                "labels": [
                  "Company"
                ],
                "properties": {
                  "name": "公司公司公司"
                }
              }
            ],
            "relationships": [
              {
                "id": "16099",
                "type": "Work",
                "startNode": "13729",
                "endNode": "17098",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35399,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13149",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AOIcWHgref4HJ8oLai52dOAVY4teQlvV"
                }
              }
            ],
            "relationships": [
              {
                "id": "35399",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13149",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35398,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13148",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "ATMkOATupb5WEZmQlpvCOK1vQOPBb1nc"
                }
              }
            ],
            "relationships": [
              {
                "id": "35398",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13148",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35397,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13147",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "ATcZPuBzOmtESHp3R3g6H6ejyEw6IluV"
                }
              }
            ],
            "relationships": [
              {
                "id": "35397",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13147",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35396,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13146",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "CMlG5bWpnyM4To0Xg7UtHWut3XpoShXC"
                }
              }
            ],
            "relationships": [
              {
                "id": "35396",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13146",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35395,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13145",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "A6ONgENIHqTGBZB3OWbDvZ2sXJ7OjzJJ"
                }
              }
            ],
            "relationships": [
              {
                "id": "35395",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13145",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35394,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13144",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "CkvuzS0xBqNFPabutoMYSggPDosxfbNK"
                }
              }
            ],
            "relationships": [
              {
                "id": "35394",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13144",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35393,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13143",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AU8IHgMTfUYNpYtA77aHogd7NJyje91t"
                }
              }
            ],
            "relationships": [
              {
                "id": "35393",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13143",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35392,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13142",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AK8P7YZSe7FwuMp1gXClbKPHGS2efOGf"
                }
              }
            ],
            "relationships": [
              {
                "id": "35392",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13142",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35407,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13157",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AtUq2XQW2iMc3XD7ij8SvWILHI77fT8x"
                }
              }
            ],
            "relationships": [
              {
                "id": "35407",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13157",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35406,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13156",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "A680yaXbRLRwsKkvLK5y6KAHcMw26hmV"
                }
              }
            ],
            "relationships": [
              {
                "id": "35406",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13156",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35405,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13155",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AdrrPBk2ipIuNObpxwWYsz6HqKpRICHh"
                }
              }
            ],
            "relationships": [
              {
                "id": "35405",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13155",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35404,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13154",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AXfFpkdvxhMopnnyCvBb0nK6pN8a8sQj"
                }
              }
            ],
            "relationships": [
              {
                "id": "35404",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13154",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35403,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13153",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AmplKJO6pLj8tKSRaUmMXlnND2mrX3vU"
                }
              }
            ],
            "relationships": [
              {
                "id": "35403",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13153",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35402,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13152",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "CaE9bgSQav3bLnJDunPdOj58l8bdoU7d"
                }
              },
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              }
            ],
            "relationships": [
              {
                "id": "35402",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13152",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35401,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13151",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "CqQoEIusihqQ5n5iU2a7VR2Hh0bSn2Y2"
                }
              }
            ],
            "relationships": [
              {
                "id": "35401",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13151",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35400,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13150",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "A1YhuzzEPGMFBWwm18kcvo2ElfXiy3Av"
                }
              }
            ],
            "relationships": [
              {
                "id": "35400",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13150",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35414,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13167",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "A5oH1eCUaqCr66KWNr2zTO30WI2eIaXe"
                }
              }
            ],
            "relationships": [
              {
                "id": "35414",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13167",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35415,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13170",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "AGecTbQbrHzmDMo9jwyXe3BZGAwxx3uV"
                }
              }
            ],
            "relationships": [
              {
                "id": "35415",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13170",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35412,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13164",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "ACOcLVhK6pccZybLU3VuSTbaWmoej53e"
                }
              }
            ],
            "relationships": [
              {
                "id": "35412",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13164",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 35413,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "13729",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "company": "公司名称农民战争",
                  "title": "测试",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13165",
                "labels": [
                  "Card"
                ],
                "properties": {
                  "cardid": "A3yAB4FRsVM10thBhQEB9DkzuG3AEseD"
                }
              }
            ],
            "relationships": [
              {
                "id": "35413",
                "type": "Has",
                "startNode": "13729",
                "endNode": "13165",
                "properties": {}
              }
            ]
          }
        }
      ],
      "stats": {
        "contains_updates": false,
        "nodes_created": 0,
        "nodes_deleted": 0,
        "properties_set": 0,
        "relationships_created": 0,
        "relationship_deleted": 0,
        "labels_added": 0,
        "labels_removed": 0,
        "indexes_added": 0,
        "indexes_removed": 0,
        "constraints_added": 0,
        "constraints_removed": 0
      }
    }
  ],
  "errors": [],
  "responseTime": 48
}';
$weight = array('user'=>'20','company'=>30,'card'=>40); // 权重
$str = json_decode($str,true);
$arr = $str['results'][0]['data'];
$nodes = $links = array();
foreach ($arr as $v){
	$nodeArr = $lineArr = array();
	if($v['meta'][0]['deleted'] === false){
		$nodeArr = $v['graph']['nodes'];
		$linkArr = $v['graph']['relationships'];
	}
	// 节点数据
	foreach ($nodeArr as $nodeV){
		switch($nodeV['labels'][0]){
			case 'User':
				// C('WEB_SERVICE_ROOT_URL')
				$nodes[$nodeV['id']] = array('category'=>1,'draggable'=>true,'symbol' => 'image://http://192.168.30.191:9999/account/avatar?path='.$nodeV['properties']['userid'],'symbolSize'=>[30,30],
				'itemStyle' =>array('normal'=>array(
						'label'=>array('position'=> 'right','textStyle'=>array('color'=>'#f39707')))),
				'name'=>$nodeV['properties']['name'],'type'=>'user','color'=>'#f39707');
				break;
			case 'Company':
				$nodes[$nodeV['id']] = array('category'=>2,'draggable'=>true,'symbol' => 'image://http://jiyanli.oradt.com/test/echarts/image/ps3.png','symbolSize'=>[30,30],
				'itemStyle' =>array('normal'=>array(
						'label'=>array('position'=> 'right','textStyle'=>array('color'=>'#006538')))),
				'name'=>$nodeV['properties']['name'],'type'=>'company','color'=>'#006538');
				break;
			case 'Card':
				$nodes[$nodeV['id']] = array('category'=>3,'draggable'=>true,'symbol' => 'image://http://www.damndigital.com/wp-content/uploads/2010/12/steve-jobs.jpg','symbolSize'=>[50,30],
				'itemStyle' =>array('normal'=>array(
						'label'=>array('position'=> 'right','textStyle'=>array('color'=>'black')))),
				'name'=>'名片id='.$nodeV['properties']['cardid'],'type'=>'card','color'=>'black');
				break;
			default:
				;
		}
	}
	// 关系线数据
	foreach ($linkArr as $linkV){

		$links[] = array('source'=>$nodes[$linkV['startNode']]['name'], 'target'=> $nodes[$linkV['endNode']]['name'], 'weight'=>$weight[$nodes[$linkV['endNode']]['type']], 'name'=>$linkV['type'],
				'itemStyle'=>array('normal'=>array('width'=>3,'color'=>$nodes[$linkV['endNode']]['color']))
		);
	}
}
// 临时显示查找数据信息
$nodes[0] = array('category'=>0,'draggable'=>true,'symbol' => 'image://http://jiyanli.oradt.com/test/echarts/image/ps1.png','symbolSize'=>[40,40],
		'itemStyle' =>array('normal'=>array(
				'color'=>'red',
				'label'=>array('position'=> 'right','textStyle'=>array('color'=>'red')))),
		'name'=>'查找人物','type'=>'search');
// 删除多余key值
foreach($nodes as $k=>$v){
	// 临时显示查找数据
	if($v['type'] == 'user'){
		$links[] = array('source'=>'查找人物', 'target'=> $v['name'], 'name'=>'Friend','weight'=>10,'itemStyle'=>array('normal'=>array('width'=>3,'color'=>'red')));
	}
	unset($nodes[$k]['color']);
	$jsnode[] = $nodes[$k];
}
$nodes = $jsnode;

?>