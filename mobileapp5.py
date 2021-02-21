from kivymd.app import MDApp
from kivymd.uix.screen import Screen
from kivymd.uix.button import MDRectangleFlatButton
from kivymd.uix.toolbar import MDToolbar
from kivy.uix.image import Image
import webbrowser


class HealthApp(MDApp):
    def build(self):
        self.theme_cls.primary_palette = "Blue"
        screen = Screen()

        text = MDToolbar(title='Health Monitor App', specific_text_color=(1, 1, 1, 1),
                         pos_hint={'center_x': 0.5, 'center_y': 0.95})

        img = Image(source="Healt.jpg", pos_hint={'center_x': 0.5, 'center_y': 0.5})

        button = MDRectangleFlatButton(text='Continue',
                                       pos_hint={'center_x': 0.5, 'center_y': 0.2},
                                       on_release=self.login)
        screen.add_widget(text)
        screen.add_widget(img)
        screen.add_widget(button)
        return screen

    def login(self, obj):
        webbrowser.open('http://myproject.org.in/employeecare/auth')


if __name__ == "__main__":
    HealthApp().run()
