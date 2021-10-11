# ipallow-tg-bot

## ~為了防止別人偷窺~

## 要先有domain和憑證窩!  
### (tg要求要webhook有憑證才可以接收訊息)  
## 先建議先看這篇筆記~
https://hackmd.io/kMpTb8XZRMGCo_p7hkZALQ  
裡面是我學習時到處翻資料最後整理的XDD  
建議先讀一下webhook是甚麼~在後續比較好了解  
## php-telergam-bot/core
在我寫好我後發現竟然有大大先寫了如此好用的code  
這位大大已經幫我們建構起很好的架構~  
可以不用重造且繼續往上加我們想設定的內容  
網址:https://github.com/php-telegram-bot/core  

## 如何設定ubuntu伺服器防火牆呢?  
我的程式碼流程架構如下~  
![image](https://github.com/a20688392/ipallow-tg-bot/blob/images/cZFKcEn.png)
### 第二步server配置
到指定位置  
例如我自己(jone)在/home/jone  
```bash=
#下載我們的自定義指令庫
cd /hone/jone
git clone https://gitlab.cmrdb.cs.pu.edu.tw/a20688392/telegram-bot.git -b 1.1.0-telegram-bot
#安裝composer
sudo apt-get install composer
#下載telegram-bot庫
cd telegram-bot
sudo composer require longman/telegram-bot
#下載monolog裝自動寫log
cd vendor
sudo composer require monolog/monolog
#將telegram-bot權限給www-data已供telegram使用
#不然會報錯下面的錯(有待調整)
sudo chown -R www-data:www-data /home/jone/telegram-bot
```
>it could not be created: Permission denied in /home/jone/telegram-bot/vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php:212\nStack trace:\n#0

### 最後結構應為下圖(簡圖)
![image](https://github.com/a20688392/ipallow-tg-bot/blob/images/g6D0vjZ.png)

## 更動config所有內容
金鑰、機器人名字、wehook_url、ssl金鑰
![image](https://github.com/a20688392/ipallow-tg-bot/blob/images/EFWZEMw.png)
### 管理員ID、可通行的群組ID(皆為數字)
![](https://github.com/a20688392/ipallow-tg-bot/blob/images/yRuwRgk.png)
### 進行開通白名單IP
ip 為哪一台server防火牆  
port為ssh的port  
user,password使用者帳密  
![](https://github.com/a20688392/ipallow-tg-bot/blob/images/zP0eYUl.png)

### 讓server能快速訪問telegram api server
```bash=
#還要去改 /etc/hosts 加上下面這串
149.154.167.99 api.telegram.org
```
### 設置排成
```bash=
vim /etc/crontab
加上下面這句(位置你隨意記得換就好)
0  0    * * *   root    sh /home/jone/ip.sh
```

到這就配置完拉 ~ 恭喜恭喜 ~
