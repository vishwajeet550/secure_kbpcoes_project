print("initilization ongoing wait for some seconds")

import face_recognition
import cv2
import numpy as np
import os
import smtplib
import imghdr
from email.message import EmailMessage
import RPi.GPIO as GPIO     # Import Library to access GPIO PIN
import time                 # To access delay function

GPIO.setmode(GPIO.BOARD)    # Consider complete raspberry-pi board
GPIO.setwarnings(False)     # To avoid same PIN use warning
# Define GPIO to LCD mapping
LCD_RS = 7
LCD_E  = 11
LCD_D4 = 12
LCD_D5 = 13
LCD_D6 = 15
LCD_D7 = 16
buzzer_pin =18
switch_pin =22
x=1
b0 =0                                       # integer for storing the delay multiple
b1 =0
b2 =0
b3 =0
b4 =0
b5 =0
b6 =0
b7 =0
servo_pin = 33
GPIO.setup(LCD_E, GPIO.OUT)  # E
GPIO.setup(LCD_RS, GPIO.OUT) # RS
GPIO.setup(LCD_D4, GPIO.OUT) # DB4
GPIO.setup(LCD_D5, GPIO.OUT) # DB5
GPIO.setup(LCD_D6, GPIO.OUT) # DB6
GPIO.setup(LCD_D7, GPIO.OUT) # DB7
GPIO.setup(buzzer_pin,GPIO.OUT)   # Set pin function as output
GPIO.setup(switch_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)   # Set pin function as input
GPIO.setup(31,GPIO.IN)
GPIO.setup(32,GPIO.IN)
GPIO.setup(29,GPIO.IN)
GPIO.setup(35,GPIO.IN)
GPIO.setup(36,GPIO.IN)
GPIO.setup(37,GPIO.IN)
GPIO.setup(38,GPIO.IN)
GPIO.setup(40,GPIO.IN)
GPIO.setup(servo_pin,GPIO.OUT)

# setup PWM process
pwm = GPIO.PWM(servo_pin,50) # 50 Hz (20 ms PWM period)

pwm.start(2) # start PWM by rotating to 90 degrees
pwm.ChangeDutyCycle(2.0) # rotate to 0 degrees
time.sleep(0.5)
pwm.ChangeDutyCycle(0) # this prevents jitter

CurrentFolder = os.getcwd() #Read current folder path
image1 = "/home/a/Documents/Face)Recognition_Hardware/Abhishek Phadtare.jpg"
image2 = "/home/a/Documents/Face)Recognition_Hardware/Aditya Kudale.jpg"
image3 = "/home/a/Documents/Face)Recognition_Hardware/Shubham Kumbhar.jpg"
image4 = "/home/a/Documents/Face)Recognition_Hardware/Vishwajeet Kadam.jpg"
# image5 = "/home/a/Documents/Face)Recognition_Hardware/Shabina Sayyed.jpg"


# This is a demo of running face recognition on live video from your webcam. It's a little more complicated than the
# other example, but it includes some basic performance tweaks to make things run a lot faster:
#   1. Process each video frame at 1/4 resolution (though still display it at full resolution)
#   2. Only detect faces in every other frame of video.

# PLEASE NOTE: This example requires OpenCV (the `cv2` library) to be installed only to read from your webcam.
# OpenCV is not required to use the face_recognition library. It's only required if you want to run this
# specific demo. If you have trouble installing it, try any of the other demos that don't require it instead.

# Get a reference to webcam #0 (the default one)
video_capture = cv2.VideoCapture(0)

# Load a second sample picture and learn how to recognize it.
Abhishek_image = face_recognition.load_image_file(image1)
Abhishek_face_encoding = face_recognition.face_encodings(Abhishek_image)[0]

# Load a second sample picture and learn how to recognize it.
Aditya_image = face_recognition.load_image_file(image2)
Aditya_face_encoding = face_recognition.face_encodings(Aditya_image)[0]

# Load a second sample picture and learn how to recognize it.
Shubham_image = face_recognition.load_image_file(image3)
Shubham_face_encoding = face_recognition.face_encodings(Shubham_image)[0]

# Load a second sample picture and learn how to recognize it.
Vishwajeet_image = face_recognition.load_image_file(image4)
Vishwajeet_face_encoding = face_recognition.face_encodings(Vishwajeet_image)[0]

# Load a second sample picture and learn how to recognize it.
# Shabina_image = face_recognition.load_image_file(image5)
# Shabina_face_encoding = face_recognition.face_encodings(Shabina_image)[0]

# Create arrays of known face encodings and their names
known_face_encodings = [
    Abhishek_face_encoding,
    Aditya_face_encoding,
    Shubham_face_encoding,
    Vishwajeet_face_encoding,
    # Shabina_face_encoding,
]
known_face_names = [
    "Abhi Phadtare",
    "Aditya Kudale",
    "Shubham Kumbhar",
    "Vishwajeet Kadam",
    "Shabina Sayyed"
]

#variable to store status of person inside home or not
#inside_home = 0
#door_open_status =0
# Initialize some variables
face_locations = []
face_encodings = []
face_names = []
process_this_frame = True


# Timing constants
E_PULSE = 0.0005
E_DELAY = 0.0005
delay = 1


# Define some device constants
LCD_WIDTH = 16    # Maximum characters per line
LCD_CHR = True
LCD_CMD = False
LCD_LINE_1 = 0x80 # LCD RAM address for the 1st line
LCD_LINE_2 = 0xC0 # LCD RAM address for the 2nd line

'''
Function Name :lcd_init()
Function Description : this function is used to initialized lcd by sending the different commands
'''
def lcd_init():
  # Initialise display
  lcd_byte(0x33,LCD_CMD) # 110011 Initialise
  lcd_byte(0x32,LCD_CMD) # 110010 Initialise
  lcd_byte(0x06,LCD_CMD) # 000110 Cursor move direction
  lcd_byte(0x0C,LCD_CMD) # 001100 Display On,Cursor Off, Blink Off
  lcd_byte(0x28,LCD_CMD) # 101000 Data length, number of lines, font size
  lcd_byte(0x01,LCD_CMD) # 000001 Clear display
  time.sleep(E_DELAY)
'''
Function Name :lcd_byte(bits ,mode)
Fuction Name :the main purpose of this function to convert the byte data into bit and send to lcd port
'''
def lcd_byte(bits, mode):
  # Send byte to data pins
  # bits = data
  # mode = True  for character
  #        False for command
 
  GPIO.output(LCD_RS, mode) # RS
 
  # High bits
  GPIO.output(LCD_D4, False)
  GPIO.output(LCD_D5, False)
  GPIO.output(LCD_D6, False)
  GPIO.output(LCD_D7, False)
  if bits&0x10==0x10:
    GPIO.output(LCD_D4, True)
  if bits&0x20==0x20:
    GPIO.output(LCD_D5, True)
  if bits&0x40==0x40:
    GPIO.output(LCD_D6, True)
  if bits&0x80==0x80:
    GPIO.output(LCD_D7, True)
 
  # Toggle 'Enable' pin
  lcd_toggle_enable()
 
  # Low bits
  GPIO.output(LCD_D4, False)
  GPIO.output(LCD_D5, False)
  GPIO.output(LCD_D6, False)
  GPIO.output(LCD_D7, False)
  if bits&0x01==0x01:
    GPIO.output(LCD_D4, True)
  if bits&0x02==0x02:
    GPIO.output(LCD_D5, True)
  if bits&0x04==0x04:
    GPIO.output(LCD_D6, True)
  if bits&0x08==0x08:
    GPIO.output(LCD_D7, True)
 
  # Toggle 'Enable' pin
  lcd_toggle_enable()
'''
Function Name : lcd_toggle_enable()
Function Description:basically this is used to toggle Enable pin
'''
def lcd_toggle_enable():
  # Toggle enable
  time.sleep(E_DELAY)
  GPIO.output(LCD_E, True)
  time.sleep(E_PULSE)
  GPIO.output(LCD_E, False)
  time.sleep(E_DELAY)
'''
Function Name :lcd_string(message,line)
Function  Description :print the data on lcd 
'''
def lcd_string(message,line):
  # Send string to display
 
  message = message.ljust(LCD_WIDTH," ")
 
  lcd_byte(line, LCD_CMD)
 
  for i in range(LCD_WIDTH):
    lcd_byte(ord(message[i]),LCD_CHR)

# Define delay between readings
delay = 5
lcd_init()
lcd_string("welcome ",LCD_LINE_1)
time.sleep(1)
lcd_byte(0x01,LCD_CMD) # 000001 Clear display
lcd_string("Face Detection",LCD_LINE_1)
lcd_string("System",LCD_LINE_2)
time.sleep(1)

GPIO.output(buzzer_pin,GPIO.LOW)  #LED ON 
while True:
    #take input from switch
    #door_open_status = 0
    lcd_byte(0x01,LCD_CMD) # 000001 Clear display
    lcd_string("Press the Button",LCD_LINE_1)
    time.sleep(0.5)
    lcd_byte(0x01,LCD_CMD) # 000001 Clear display
    lcd_string("Press the Button",LCD_LINE_1)
    time.sleep(0.5)
    if GPIO.input(switch_pin) == GPIO.LOW:
        GPIO.output(buzzer_pin,GPIO.HIGH)  #LED ON
        time.sleep(2)
        GPIO.output(buzzer_pin,GPIO.LOW)  #LED ON
        while(1):
            lcd_string("Press the Button",LCD_LINE_1)
            time.sleep(0.5)
            if (GPIO.input(40) == True):
                time.sleep(0.001)
            if (GPIO.input(40) == True):
                    b7=1                                     # if pin19 is high bit7 is true
            if (GPIO.input(38) == True):
                time.sleep(0.001)
                if (GPIO.input(38) == True):
                    b6=1                                     # if pin13 is high bit6 is true
            if (GPIO.input(37) == True):
                time.sleep(0.001)
                if (GPIO.input(37) == True):
                    b5=1                                    # if pin6 is high bit5 is true
            if (GPIO.input(36) == True):
                time.sleep(0.001)
                if (GPIO.input(36) == True):
                    b4=1                                   # if pin5 is high bit4 is true           
            if (GPIO.input(35) == True):
                time.sleep(0.001)
                if (GPIO.input(35) == True):
                    b3=1                                  # if pin22 is high bit3 is true
            if (GPIO.input(29) == True):
                time.sleep(0.001)
                if (GPIO.input(29) == True):
                    b2=1                                 # if pin27 is high bit2 is true            
            if (GPIO.input(32) == True):
                time.sleep(0.001)
                if (GPIO.input(32) == True):
                    b1=1                                  # if pin17 is high bit1 is true
            if (GPIO.input(31) == True):
                time.sleep(0.001)
                if (GPIO.input(31) == True):
                    b0=1                                      # if pin4 is high bit0 is true
            x = (1*b0)+(2*b1)                        # representing the bit values from LSB to MSB
            x = x+(4*b2)+(8*b3)
            x = x+(16*b4)+(32*b5)
            x = x+(64*b6)+(128*b7)
            #x = x/1.275
            x = x/0.615
            #temp=100,ref=2000mv,read=255/200=1.275countper10mv or 1.275count for 1degree
            print ( x)                                              # print the ADC value
            b0=b1=b2=b3=b4=b5=b6=b7=0      # reset the values
            time.sleep(0.01)  
            #lcd_byte(0x01,LCD_CMD) # 000001 Clear display
            #lcd_string("Press the Button",LCD_LINE_1)
            #lcd_string("temp= ",LCD_LINE_2)
            lcd_string("temp= " + str(int(x)),LCD_LINE_2)
            time.sleep(0.1)
            #if GPIO.input(pir_pin) == GPIO.HIGH:
                 #someone inside home
                 #print("someone inside home")
                 #inside_home = 0                
            #else :
                 #noone inside home
                 #print("nobody inside home")
                 #inside_home = 1         
            # Grab a single frame of video
            ret, frame = video_capture.read()

            # Resize frame of video to 1/4 size for faster face recognition processing
            small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)

            # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
            rgb_small_frame = small_frame[:, :, ::-1]

            # Only process every other frame of video to save time
            if process_this_frame:
                # Find all the faces and face encodings in the current frame of video
                face_locations = face_recognition.face_locations(rgb_small_frame)
                face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)

                face_names = []
                for face_encoding in face_encodings:
                    # See if the face is a match for the known face(s)
                    matches = face_recognition.compare_faces(known_face_encodings, face_encoding)
                    name = "Unknown"

                    # # If a match was found in known_face_encodings, just use the first one.
                    # if True in matches:
                    #     first_match_index = matches.index(True)
                    #     name = known_face_names[first_match_index]

                    # Or instead, use the known face with the smallest distance to the new face
                    face_distances = face_recognition.face_distance(known_face_encodings, face_encoding)
                    best_match_index = np.argmin(face_distances)
                    if matches[best_match_index]:
                        name = known_face_names[best_match_index]
                    face_names.append(name)
                    if x < 38:
                        if GPIO.input(switch_pin) == GPIO.LOW:
                            if(name == "Unknown"):
                                #if someone inside home then do not send image on email
                                #if(inside_home == 0):
                                    lcd_byte(0x01,LCD_CMD) # 000001 Clear display
                                    lcd_string("Welcome",LCD_LINE_1)
                                    lcd_string("Unknown person",LCD_LINE_2)
                                    GPIO.output(buzzer_pin,GPIO.HIGH)  #LED ON
                                    time.sleep(2)
                                    GPIO.output(buzzer_pin,GPIO.LOW)  #LED ON
                                    i = 0
                                    while i < 1:
                                        print("sending image on mail")
                                        lcd_string("Sending mail",LCD_LINE_1)
                                        #return_value, image = video_capture.read()
                                        cv2.imwrite('opencv.png', frame)
                                        i += 1
                                        Sender_Email = "prioritywisedevicecontrol2021@gmail.com"
                                        Reciever_Email = "theftidentification2020@gmail.com"
                                        Password = "pyrderxgvpscwtkx" #type your password here
                                        newMessage = EmailMessage()                         
                                        newMessage['Subject'] = "Visitor Image" 
                                        newMessage['From'] = Sender_Email                   
                                        newMessage['To'] = Reciever_Email
                                        newMessage.set_content('Name=' + name +'TEMP= ' + str(x) +' Unknown person found. Image attached!') 
                                        with open('opencv.png', 'rb') as f:
                                            image_data = f.read()
                                            image_type = imghdr.what(f.name)
                                            image_name = f.name
                                        newMessage.add_attachment(image_data, maintype='image', subtype=image_type, filename=image_name)
                                        with smtplib.SMTP_SSL('smtp.gmail.com', 465) as smtp:
                                            smtp.login(Sender_Email, Password)              
                                            smtp.send_message(newMessage)
                                            time.sleep(1)
                            else:
                                lcd_byte(0x01,LCD_CMD) # 000001 Clear display
                                lcd_string("Welcome",LCD_LINE_1)
                                lcd_string(name,LCD_LINE_2)
                                i = 0
                                while i < 1:
                                    print("sending image on mail")
                                    lcd_string("Sending mail",LCD_LINE_1)
                                    #return_value, image = video_capture.read()
                                    cv2.imwrite('opencv.png', frame)
                                    i += 1
                                    Sender_Email = "prioritywisedevicecontrol2021@gmail.com"
                                    Reciever_Email = "theftidentification2020@gmail.com"
                                    Password = "pyrderxgvpscwtkx" #type your password here
                                    newMessage = EmailMessage()                         
                                    newMessage['Subject'] = "Visitor Image" 
                                    newMessage['From'] = Sender_Email                   
                                    newMessage['To'] = Reciever_Email                                
                                    newMessage.set_content('Name=' + name +'TEMP= ' + str(x) +' known person found. Image attached!') 
                                    with open('opencv.png', 'rb') as f:
                                        image_data = f.read()
                                        image_type = imghdr.what(f.name)
                                        image_name = f.name
                                    newMessage.add_attachment(image_data, maintype='image', subtype=image_type, filename=image_name)
                                    with smtplib.SMTP_SSL('smtp.gmail.com', 465) as smtp:
                                        smtp.login(Sender_Email, Password)              
                                        smtp.send_message(newMessage)
                                        time.sleep(1)
                                        lcd_string("  OPENING GATE  ",LCD_LINE_1)
                                        time.sleep(5)
                                        lcd_string("  GATE OPENED   ",LCD_LINE_1)
                                        pwm.ChangeDutyCycle(7.0) # rotate to 90 degrees
                                        time.sleep(10)
                                        lcd_string("  CLOSING GATE  ",LCD_LINE_1)
                                        time.sleep(5)
                                        pwm.ChangeDutyCycle(2.0) # rotate to 90 degrees
                                        time.sleep(0.5)
                                        pwm.ChangeDutyCycle(0) # this prevents jitter
                    else:
                        lcd_byte(0x01,LCD_CMD) # 000001 Clear display
                        lcd_string("HIGH TEMPERATURE",LCD_LINE_1)
                        lcd_string("  NOT ALLOWED   ",LCD_LINE_2)
                        GPIO.output(buzzer_pin,GPIO.HIGH)  #LED ON
                        time.sleep(2)
                        GPIO.output(buzzer_pin,GPIO.LOW)  #LED ON
                        time.sleep(5)
            process_this_frame = not process_this_frame

            # Display the results
            for (top, right, bottom, left), name in zip(face_locations, face_names):
                # Scale back up face locations since the frame we detected in was scaled to 1/4 size
                top *= 4
                right *= 4
                bottom *= 4
                left *= 4

                # Draw a box around the face
                cv2.rectangle(frame, (left, top), (right, bottom), (0, 0, 255), 2)

                # Draw a label with a name below the face
                cv2.rectangle(frame, (left, bottom - 35), (right, bottom), (0, 0, 255), cv2.FILLED)
                font = cv2.FONT_HERSHEY_DUPLEX
                cv2.putText(frame, name, (left + 6, bottom - 6), font, 1.0, (255, 255, 255), 1)

            # Display the resulting image
            cv2.imshow('Video', frame)
            if (cv2.waitKey(2) == 27):
                cv2.destroyAllWindows()
                break


# Release handle to the webcam
video_capture.release()
cv2.destroyAllWindows()
