
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
import time
import os

pwd = 'hahaha'

maillist = [
"keviiiooo1@163.com",
"keviiiooo2@163.com",
"keviiiooo3@163.com",
"keviiiooo4@163.com",
"keviiiooo5@163.com",
"sungoesdown1993@163.com",
"desktop24699252@163.com",
"490578183@qq.com",
"xiaofeixiaooo2@163.com",
"qingsongxiongooo3@163.com",
"qingsongxiongooo6@163.com",
"qingsongxiongooo1@163.com",
"xiaofeixiaooo1@163.com",
"xiaofeixiaooo3@163.com",
"qingsongxiongooo2@163.com",
"qingsongxiongooo4@163.com",
"qingsongxiongooo5@163.com",
"qingsongxiongooo7@163.com",
"desktop24699251@163.com",
"majijiooo@163.com",
"majijiooo1@163.com",
"majijiooo2@163.com",
"majijiooo3@163.com",
"majijiooo4@163.com",
"majijiooo5@163.com",
"majijiooo6@163.com",
"langyabangooo@163.com",
"weisijieooo@163.com",
"huaqianguuu@126.com",
"xieyuyuyu@126.com",
"xiehouyee@126.com",
"xiaojinghuann@126.com",
"meichangsuu@126.com",
"wangzhizhii@126.com",
"fangtianshuu@126.com",
"xieyanjiee@126.com",
"yangzhongweii@126.com",
"wanghaichuann@126.com",
"liyunjiann@126.com",
"songchuanshengg@126.com",
"suzhelinn@126.com",
"lujunyee@126.com",
"xieyuyueee@126.com",
"zhanggongzhuu@126.com",
"huangxiaomingm@126.com",
"shijingshann@126.com",
"songchengxiann126@126.com",
"weiguoqiangg126@126.com",
"fujieyu126@126.com",
"yanhuashei@163.com",
"nihaonong@126.com",
"maxiaolinibang@163.com",
"niheishima@yeah.net",
"fulibin123@126.com",
"jack20039@hotmail.com",
"nishuowoniyiqi@163.com",
"1102024015@qq.com",
"heinimahong@qq.com",
"nationyousuck@163.com",
"huangwode@tom.com",
"2816845621@qq.com",
"hahaonlylove@tom.com",
"jjjjackjjj@tom.com",
"hongnimahei@qq.com",
"nimahonghei@163.com",
"kxiaotianshik@tom.com",
"yesstate@tom.com",
"havebeenforlove@tom.com",
"fenzhongdeganjue@tom.com",
"no_station@163.com",
"yuchen2078@sina.com",
"981136838@qq.com",
"desktop24699254@163.com",
"desktop24699255@163.com",
"one_stepclozer@163.com",
"desktop24699256@163.com",
"1075300136@qq.com",
"hybirylilun@163.com",
"shijieyuandi@163.com",
]

# maillist = ["hybirylilun@163.com"]

left_account = maillist[:]
job_num = 0

for mail in maillist:
     browser = webdriver.Chrome()
     browser.set_window_position(2000,1000)
     browser.maximize_window()

     browser.get("http://coding.net/login") # Load page

     elem = browser.find_element_by_id("email") # Find the query box
     elem.send_keys(mail)

     elem = browser.find_element_by_id("password") # Find the query box
     elem.send_keys(pwd + Keys.RETURN)

     #### login is done ####

     ### NEW A TASK
     browser.get("http://coding.net/user/tasks") # Load page
     time.sleep(3)
     try:
         ct = browser.find_element_by_css_selector("button.ui.small.green.button")
     except NoSuchElementException:
         ct = browser.find_element_by_css_selector("button.ui.small.green.button")
     ct.click()

     time.sleep(3)

     try:
          title = browser.find_element_by_name('name')
     except NoSuchElementException:
          title = browser.find_element_by_name('name')
     today = time.strftime('%m-%d',time.localtime(time.time()))

     title.send_keys(today)
     ok = browser.find_element_by_css_selector("a.ui.ok.button.green")
     ok.click()

     time.sleep(0.2) # Let the page load, will be added to the API
     ### NEW TASK OVER

     browser.get("http://coding.net/user/account/credit")
     time.sleep(0.2)
     browser.get_screenshot_as_file('/Screenshots/'+mail+'.png')
     try:
          balance = browser.find_element_by_css_selector("strong.green.ng-binding.ng-scope")
     except NoSuchElementException:
          balance = browser.find_element_by_css_selector("strong.green.ng-binding.ng-scope")
     balance = balance.text

     # write a log
     job_num += 1
     left_account.remove(mail)
     left_account_str = "[\"" + "\",\"".join(left_account) + "\"]"

     log = today+":"+str(job_num)+" [job:"+mail+"  balance: "+balance+"] "+" [left:"+str(len(left_account))+"] "+left_account_str+"\r\n";
     output = open(today+'_exe_log.txt', 'a')
     output .write(log)
     output .close()
    
     log = str(job_num)+ "." + mail + "  balance: "+balance+"\r";
     output = open(today+'_balance.txt', 'a')
     output .write(log)
     output .close()

     # try to logout, did not work
     # avatar = browser.find_element_by_css_selector("a.ui.avatar.image")
     # try:
     #      ct = browser.find_element_by_xpath("//a[@ng-click='logout();']")
     # except NoSuchElementException:
     #      ct = browser.find_element_by_xpath("//a[@ng-click='logout();']")
     # actions = webdriver.ActionChains(browser)
     # actions.move_to_element(avatar).click(ct).perform()
     # ct.click()

     time.sleep(2)
     browser.quit()

