import React from 'react';

import { Colors } from '../compontents/styles';
const {primary, tertiary} = Colors;

import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';

import Login from './../screens/Login';
import Signup from './../screens/Signup';
import Welcome from './../screens/Welcome';
import Front from './../screens/Front';
import Details from '../screens/Details';

const Stack = createNativeStackNavigator();

const RootStack = () => {
    return (
        <NavigationContainer>
            <Stack.Navigator
            screenOptions={{
                headerStyled: {
                    backgroundColor: 'transparent'
                },
                headerTintColor: tertiary,
                headerTransparent: true,
                headerTitle: '',
                headerLeftContainerStyle: {
                    paddingLeft: 20
                }
            }}
            initialRouteName="Login"
            >
                <Stack.Screen name="Login" component={Login}/>
                <Stack.Screen name="Signup" component={Signup}/>
                <Stack.Screen options={{headerTintColor: primary}} name="Welcome" component={Welcome}/>
                <Stack.Screen name="Front" component={Front}/>
                <Stack.Screen name="Details" component={Details}/>

            </Stack.Navigator>
        </NavigationContainer>
    );
}

export default RootStack;