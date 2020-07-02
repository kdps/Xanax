import React from 'react';
import {createAppContainer} from 'react-navigation';
import {createStackNavigator, createBottomTabNavigator} from 'react-navigation-stack';
import MainScreen from './source/screen/main_screen.js';


// TODO


const AppContainer = createAppContainer(stackNavigator);
export default AppContainer;
