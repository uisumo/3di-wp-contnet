window.globalProvideData('slide', '{"title":"The Hardwired to Connect report discovered the following three basic needs that must be met if kids are to grow into flourishing healthy adults.","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"tween","slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"5dFX66NPkQQ","lmsId":"Slide5","width":1000,"height":562,"resume":true,"background":{"type":"swf","imagedata":{"assetId":25,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"644tnSFJWgw","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"noteq","valuea":"5e1wbi4YIs9.$DragConnectData","typea":"property","valueb":"","typeb":"string"}},"thenActions":[{"kind":"eval_interaction","id":"_this.6box1VvLnwf"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_6eEPB2nFPJR.InvalidPromptSlide"}}]},{"kind":"exe_actiongroup","id":"_this.NavigationRestrictionNextSlide_644tnSFJWgw"}]},"ReviewInt_692kNVeEDwE":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.6c2POc85yKF"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.5vOjVQJwW06"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.5kvwpktnYI3"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.6WRpoRQrwr5"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5e1wbi4YIs9"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6box1VvLnwf.$Status","typea":"property","valueb":"correct","typeb":"string"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"692kNVeEDwE_CorrectReview"}}],"elseActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"692kNVeEDwE_IncorrectReview"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_692kNVeEDwE","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns01001000101"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_692kNVeEDwE"}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_692kNVeEDwE"}]}]}]},"ReviewIntCorrectIncorrect_692kNVeEDwE":{"kind":"actiongroup","actions":[{"kind":"set_review","objRef":{"type":"string","value":"692kNVeEDwE.6c2POc85yKF"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"692kNVeEDwE.5vOjVQJwW06"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"692kNVeEDwE.5kvwpktnYI3"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"692kNVeEDwE.6WRpoRQrwr5"},"enabled":{"type":"boolean","value":true}},{"kind":"set_review","objRef":{"type":"string","value":"5e1wbi4YIs9"},"enabled":{"type":"boolean","value":true}}]},"AnsweredInt_692kNVeEDwE":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_692kNVeEDwE"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001000101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001000101"}]}]},"DisableChoices_692kNVeEDwE":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.6c2POc85yKF"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.5vOjVQJwW06"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.5kvwpktnYI3"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"692kNVeEDwE.6WRpoRQrwr5"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5e1wbi4YIs9"},"enabled":{"type":"boolean","value":false}}]},"692kNVeEDwE_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6box1VvLnwf.$Status","typea":"property","valueb":"correct","typeb":"string"},{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$QuizComplete","typea":"property","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_692kNVeEDwE"}],"elseActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6box1VvLnwf.$Status","typea":"property","valueb":"incorrect","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"6box1VvLnwf.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_692kNVeEDwE"}]}]}]}]},"SetLayout_pxabnsnfns01001000101":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001000101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001000101"}]}]},"NavigationRestrictionNextSlide_644tnSFJWgw":{"kind":"actiongroup","actions":[{"kind":"gotoplay","window":"_current","wndtype":"normal","objRef":{"type":"string","value":"_parent.6IOjfLuiAXC"}}]},"NavigationRestrictionPreviousSlide_644tnSFJWgw":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns01001000101"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns01001000101"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_player.#TimelineCompleted_644tnSFJWgw","typea":"var","valueb":false,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_692kNVeEDwE","typea":"var","valueb":false,"typeb":"boolean"}]}},"thenActions":[{"kind":"enable_frame_control","name":"next","enable":false},{"kind":"enable_frame_control","name":"swiperight","enable":false}]},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6eEPB2nFPJR","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_6eEPB2nFPJR","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_692kNVeEDwE","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_692kNVeEDwE"}],"elseActions":[{"kind":"exe_actiongroup","id":"692kNVeEDwE_CheckAnswered"}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_692kNVeEDwE","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_692kNVeEDwE","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"nextviewedslide","quizRef":{"type":"string","value":"_player.6HyXgqrh1xK"},"completed_slide_ref":{"type":"string","value":"_player.5mbKk5DfB96.5nnSyv28G8M"}}],"elseActions":[]}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_644tnSFJWgw"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_644tnSFJWgw"}]},{"kind":"ontimelinecomplete","actions":[{"kind":"adjustvar","variable":"_player.TimelineCompleted_644tnSFJWgw","operator":"set","value":{"type":"boolean","value":true}},{"kind":"enable_frame_control","name":"next","enable":true},{"kind":"enable_frame_control","name":"swiperight","enable":true}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":4000,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5h9SGXjLq6X"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6qzcX1jDnHt"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5gCYdTusJqY"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6Umy73knJpl"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6cVL25opklD"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6cVL25opklD.6EjcpDWR3YQ"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6cVL25opklD.6FwPiK0nOGA"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5d4kxdBtwZN"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"692kNVeEDwE"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"692kNVeEDwE.6WRpoRQrwr5"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"692kNVeEDwE.5kvwpktnYI3"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"692kNVeEDwE.6c2POc85yKF"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"692kNVeEDwE.5vOjVQJwW06"}}]},{"kind":"ontimelinetick","time":500,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5e1wbi4YIs9"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6FRs2mZZQu6"}}]},{"kind":"ontimelinetick","time":1000,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6eHjueDGAbC"}}]},{"kind":"ontimelinetick","time":1500,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5fRZUcXlgKq"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6mTaPZ7pVoL"}}]},{"kind":"ontimelinetick","time":2500,"actions":[{"kind":"hide","transition":"custom","animationId":"Exit","reverse":false,"objRef":{"type":"string","value":"6eHjueDGAbC"}}]}]},"objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":11,"id":"01","url":"story_content/5bv96aUJgB1_80_DX1998_DY1998.swf","type":"normal","altText":"blue-lens_flare.png","width":1920,"height":1078,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":1,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":280.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":561,"altText":"blue-lens_flare.png","pngfb":false,"pr":{"l":"Lib","i":25}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":561,"strokewidth":0}},"width":999,"height":561,"resume":true,"useHandCursor":true,"id":"5h9SGXjLq6X"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":12,"id":"01","url":"story_content/6bnaWDXoZ71_X_80_DX1998_DY1998.swf","type":"normal","altText":"lens_flare-middle.png","width":1920,"height":1080,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":1,"yPos":1,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":280.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":561,"altText":"lens_flare-middle.png","pngfb":false,"pr":{"l":"Lib","i":26}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":561,"strokewidth":0}},"width":999,"height":561,"resume":true,"useHandCursor":true,"id":"6qzcX1jDnHt"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","shapemaskId":"","xPos":0,"yPos":198,"tabIndex":7,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":58.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":1000,"bottom":117,"altText":"Rectangle 1","pngfb":false,"pr":{"l":"Lib","i":55}},"html5data":{"xPos":-1,"yPos":-1,"width":1001,"height":118,"strokewidth":0}},"width":1000,"height":117,"resume":true,"useHandCursor":true,"id":"5gCYdTusJqY"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":13,"id":"01","url":"story_content/6BjXnrYJoHb_X_80_P_79_0_490_1080_DX1124_DY1124.swf","type":"normal","altText":"blue stripe.png","width":490,"height":1080,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":689,"yPos":-1,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":127.5,"rotateYPos":281,"scaleX":100,"scaleY":100,"alpha":100,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":255,"bottom":562,"altText":"blue stripe.png","pngfb":false,"pr":{"l":"Lib","i":28}},"html5data":{"xPos":0,"yPos":0,"width":255,"height":562,"strokewidth":0}},"width":255,"height":562,"resume":true,"useHandCursor":true,"id":"6Umy73knJpl"},{"kind":"objgroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":14,"id":"01","url":"story_content/5knHgIRwW2I_80_DX1998_DY1998.swf","type":"normal","altText":"objectives.png","width":1920,"height":301,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":2,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":84.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":169,"altText":"objectives.png","pngfb":false,"pr":{"l":"Lib","i":29}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":169,"strokewidth":0}},"width":999,"height":169,"resume":true,"useHandCursor":true,"id":"6EjcpDWR3YQ"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6FwPiK0nOGA_419085553","id":"01","linkId":"txt__default_6FwPiK0nOGA","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":835,"bottom":141,"pngfb":false,"pr":{"l":"Lib","i":31}}}],"shapemaskId":"","xPos":78,"yPos":8,"tabIndex":3,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":425,"rotateYPos":73.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":850,"bottom":147,"altText":"The Hardwired to Connect report discovered the following three basic needs that must be met if kids are to grow into flourishing healthy adults.","pngfb":false,"pr":{"l":"Lib","i":30}},"html5data":{"xPos":-1,"yPos":-1,"width":851,"height":148,"strokewidth":0}},"width":850,"height":147,"resume":true,"useHandCursor":true,"id":"6FwPiK0nOGA"}],"accType":"text","altText":"Group\\r\\n 1","shapemaskId":"","xPos":0,"yPos":0,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":84.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":5,"scrolling":true,"shuffleLock":false,"width":999,"height":169,"resume":true,"useHandCursor":true,"id":"6cVL25opklD"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":15,"id":"01","url":"story_content/5r1z8b1M9OB_X_80_P_0_0_904_701_DX718_DY718.swf","type":"normal","altText":"ethernet-cable.png","width":905,"height":701,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":280,"tabIndex":12,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":179.5,"rotateYPos":139,"scaleX":100,"scaleY":100,"alpha":100,"depth":6,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":359,"bottom":278,"altText":"ethernet-cable.png","pngfb":false,"pr":{"l":"Lib","i":32}},"html5data":{"xPos":0,"yPos":0,"width":359,"height":278,"strokewidth":0}},"width":359,"height":278,"resume":true,"useHandCursor":true,"id":"5d4kxdBtwZN"},{"kind":"scrollarea","contentwidth":178,"contentheight":215,"objects":[{"kind":"shufflegroup","objects":[{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_6WRpoRQrwr5","reviewdata":0,"shapemaskId":"","xPos":21,"yPos":181,"tabIndex":17,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":89,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6WRpoRQrwr5_2042950448","type":"vectortext","altText":"nuclear family","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":158,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":57}}},"html5data":{"xPos":-1,"yPos":-1,"width":179,"height":36,"strokewidth":0}},"width":178,"height":35,"resume":true,"useHandCursor":true,"id":"6WRpoRQrwr5"},{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_5kvwpktnYI3","reviewdata":0,"shapemaskId":"","xPos":21,"yPos":122,"tabIndex":16,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":89,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":2,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_5kvwpktnYI3_534450914","type":"vectortext","altText":"religion","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":91,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":58}}},"html5data":{"xPos":-1,"yPos":-1,"width":179,"height":36,"strokewidth":0}},"width":178,"height":35,"resume":true,"useHandCursor":true,"id":"5kvwpktnYI3"},{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_6c2POc85yKF","reviewdata":0,"shapemaskId":"","xPos":21,"yPos":6,"tabIndex":14,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":89,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_6c2POc85yKF_846581289","type":"vectortext","altText":"sports team","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":138,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":59}}},"html5data":{"xPos":-1,"yPos":-1,"width":179,"height":36,"strokewidth":0}},"width":178,"height":35,"resume":true,"useHandCursor":true,"background":{"type":"swf","imagedata":{"assetId":26,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"6c2POc85yKF"},{"kind":"dragitem","style":"wordbank","connectdata":"choices.choice_5vOjVQJwW06","reviewdata":1,"shapemaskId":"","xPos":21,"yPos":64,"tabIndex":15,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":89,"rotateYPos":17.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":4,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xB7EBFF","alpha":100,"stop":0},{"kind":"color","rgb":"0xA1D9EF","alpha":100,"stop":100}]}}],"data":{"hotlinkId":"","accState":0,"textdata":{"uniqueId":"txt_5vOjVQJwW06_1067791846","type":"vectortext","altText":"community","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":126,"bottom":32,"pngfb":false,"pr":{"l":"Lib","i":60}}},"html5data":{"xPos":-1,"yPos":-1,"width":179,"height":36,"strokewidth":0}},"width":178,"height":35,"resume":true,"useHandCursor":true,"background":{"type":"swf","imagedata":{"assetId":27,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"5vOjVQJwW06"}],"shuffle":false,"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":0,"rotateYPos":0,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"width":0,"height":0,"resume":false,"useHandCursor":true,"id":""}],"shapemaskId":"","xPos":708,"yPos":312,"tabIndex":13,"tabEnabled":false,"xOffset":0,"yOffset":0,"rotateXPos":123.5,"rotateYPos":125,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":7,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"html5data":{"url":"","xPos":708,"yPos":312,"width":247,"height":249,"strokewidth":0}},"width":247,"height":249,"resume":true,"useHandCursor":true,"background":{"type":"vector","vectorData":{"left":0,"top":0,"right":248,"bottom":250,"altText":"Word Bank","pngfb":false,"pr":{"l":"Lib","i":56}}},"id":"692kNVeEDwE"},{"kind":"droparea","style":"wordbank","reviewdata":0,"shapemaskId":"","xPos":403,"yPos":219,"tabIndex":10,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":89,"rotateYPos":18.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":8,"scrolling":true,"shuffleLock":false,"colors":[{"kind":"color","name":"hover","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xFFDD63","alpha":100,"stop":0}]}}],"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":178,"height":37,"resume":true,"useHandCursor":true,"id":"5e1wbi4YIs9"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6FRs2mZZQu6_1540569654","id":"01","linkId":"txt__default_6FRs2mZZQu6","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":443,"bottom":85,"pngfb":false,"pr":{"l":"Lib","i":62}}}],"shapemaskId":"","xPos":178,"yPos":208,"tabIndex":8,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":255.5,"rotateYPos":46,"scaleX":100,"scaleY":100,"alpha":100,"depth":9,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":511,"bottom":92,"altText":"3. ) They need a                        to belong to.","pngfb":false,"pr":{"l":"Lib","i":61}},"html5data":{"xPos":-1,"yPos":-1,"width":512,"height":93,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":511,"height":92,"resume":true,"useHandCursor":true,"id":"6FRs2mZZQu6"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":20,"id":"01","url":"story_content/6Z3PuPCM2Z4_80_DX232_DY232.swf","type":"normal","altText":"forward_arrow-512.png","width":232,"height":149,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":761,"yPos":176,"tabIndex":6,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":58,"rotateYPos":37.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":10,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":116,"bottom":75,"altText":"forward_arrow-512.png","pngfb":false,"pr":{"l":"Lib","i":40}},"html5data":{"xPos":0,"yPos":0,"width":116,"height":75,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":116,"height":75,"resume":true,"useHandCursor":true,"id":"5fRZUcXlgKq"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6mTaPZ7pVoL_-89573715","id":"01","linkId":"txt__default_6mTaPZ7pVoL","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":149,"bottom":35,"pngfb":false,"pr":{"l":"Lib","i":42}}}],"shapemaskId":"","xPos":736,"yPos":251,"tabIndex":11,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":83.5,"rotateYPos":20.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":11,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":167,"bottom":41,"altText":"Click & Drag","pngfb":false,"pr":{"l":"Lib","i":41}},"html5data":{"xPos":-1,"yPos":-1,"width":168,"height":42,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":167,"height":41,"resume":true,"useHandCursor":true,"id":"6mTaPZ7pVoL"},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":21,"id":"01","url":"story_content/5aTJd2PblL9_80_DX222_DY222.swf","type":"normal","altText":"finger.png","width":222,"height":222,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":878,"yPos":217,"tabIndex":9,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":55.5,"rotateYPos":55.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":12,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":111,"bottom":111,"altText":"finger.png","pngfb":false,"pr":{"l":"Lib","i":43}},"html5data":{"xPos":0,"yPos":0,"width":111,"height":111,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":1500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":1500,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"878","y":"217","dx":"0","dy":"0"},"anchorb":{"x":"647.485","y":"218.3877","dx":"0","dy":"0"}}],"duration":1500,"easing":"cubic","easingdir":"easeinout"}}]},{"kind":"animation","id":"Exit","duration":750,"hidetextatend":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"100","dstart":"0","end":"0","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easeout"}}]},{"kind":"animation","id":"6iYOkXNgvMr","duration":1500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":1500,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"878","y":"217","dx":"0","dy":"0"},"anchorb":{"x":"647.485","y":"218.3877","dx":"0","dy":"0"}}],"duration":1500,"easing":"cubic","easingdir":"easeinout"}}]}],"width":111,"height":111,"resume":true,"useHandCursor":true,"id":"6eHjueDGAbC","events":[{"kind":"ontransitionin","actions":[]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"692kNVeEDwE_CorrectReview","id":"01","linkId":"692kNVeEDwE_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":540,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":45}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":18,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":13,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":44}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"692kNVeEDwE_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"692kNVeEDwE_IncorrectReview","id":"01","linkId":"692kNVeEDwE_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":549,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":47}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":19,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":14,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":46}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"692kNVeEDwE_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","animations":[{"kind":"animation","id":"5dFX66NPkQQ","duration":500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":500,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":500,"easing":"linear","easingdir":"easein"}}]}],"useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');